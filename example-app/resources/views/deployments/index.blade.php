<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        xintegrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Live Deployment View (ফায়ারবেস)</title>

    <style>
        /* Ensuring a clean look with some padding */
        body {
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h1>লাইভ ডেপ্লয়মেন্ট তালিকা (Live Deployment List)</h1>
        <p class="text-muted">আপনার ডাটাবেসে ইনসার্ট করা ডেটা দেখানো হচ্ছে।</p>
        <br>
        <a href="#">
            <button class="btn btn-md btn-primary">নতুন ডেপ্লয়মেন্ট যোগ করুন</button>
        </a>
    </div>

    <div class="container mt-4">
        <!-- Container where the dynamic table will be rendered -->
        <div id="report-container">
            <div class="alert alert-info text-center" role="alert">
                ডাটা লোড হচ্ছে... (Initializing Firebase)
            </div>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import {
            getFirestore, collection, query, onSnapshot, setLogLevel
        } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

        // Global variables provided by the environment
        const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
        const firebaseConfig = JSON.parse(typeof __firebase_config !== 'undefined' ? __firebase_config : '{}');
        const initialAuthToken = typeof __initial_auth_token !== 'undefined' ? __initial_auth_token : null;

        let db, auth;
        let userId = null;
        let isAuthReady = false;

        // Data holders (Map for easy lookups, Array for deployments)
        let applicationsMap = {};
        let environmentsMap = {};
        let deploymentsArray = [];

        setLogLevel('Debug');

        // --- 1. FIREBASE INITIALIZATION AND AUTHENTICATION ---
        try {
            const app = initializeApp(firebaseConfig);
            db = getFirestore(app);
            auth = getAuth(app);

            // Authentication
            onAuthStateChanged(auth, async (user) => {
                if (user) {
                    userId = user.uid;
                } else if (initialAuthToken) {
                    try {
                        await signInWithCustomToken(auth, initialAuthToken);
                        userId = auth.currentUser.uid;
                    } catch (error) {
                        console.error("Custom token sign-in failed:", error);
                        await signInAnonymously(auth);
                        userId = auth.currentUser.uid;
                    }
                } else {
                    await signInAnonymously(auth);
                    userId = auth.currentUser.uid;
                }
                isAuthReady = true;
                console.log("Authentication Ready. User ID:", userId);
                startDataListeners();
            });

        } catch (error) {
            console.error("Firebase Initialization Error:", error);
            document.getElementById('report-container').innerHTML = `
                <div class="alert alert-danger text-center" role="alert">
                    Firebase শুরু করতে ব্যর্থ। ত্রুটি দেখুন।
                </div>
            `;
        }

        // --- 2. DATA LISTENERS (Fetching live data from collections) ---
        function getCollectionPath(collectionName) {
            // Private data path for the current user: /artifacts/{appId}/users/{userId}/{collectionName}
            return `artifacts/${appId}/users/${userId}/${collectionName}`;
        }

        function startDataListeners() {
            if (!isAuthReady || !userId || !db) return;

            // 2a. Listen to Applications (Parent of Environments)
            const qApps = query(collection(db, getCollectionPath('applications')));
            onSnapshot(qApps, (snapshot) => {
                applicationsMap = {};
                snapshot.forEach(doc => {
                    applicationsMap[doc.id] = { id: doc.id, ...doc.data() };
                });
                console.log("Applications updated:", Object.keys(applicationsMap).length);
                renderDeploymentReport();
            }, (error) => console.error("Error fetching applications:", error));

            // 2b. Listen to Environments (Parent of Deployments, Child of Applications)
            const qEnvs = query(collection(db, getCollectionPath('environments')));
            onSnapshot(qEnvs, (snapshot) => {
                environmentsMap = {};
                snapshot.forEach(doc => {
                    environmentsMap[doc.id] = { id: doc.id, ...doc.data() };
                });
                console.log("Environments updated:", Object.keys(environmentsMap).length);
                renderDeploymentReport();
            }, (error) => console.error("Error fetching environments:", error));

            // 2c. Listen to Deployments (Child row)
            const qDepls = query(collection(db, getCollectionPath('deployments')));
            onSnapshot(qDepls, (snapshot) => {
                deploymentsArray = [];
                snapshot.forEach(doc => {
                    // Firestore timestamps need conversion
                    const data = doc.data();
                    const created_at = data.created_at && data.created_at.seconds ?
                        new Date(data.created_at.seconds * 1000) : null;

                    deploymentsArray.push({ id: doc.id, ...data, created_at });
                });
                console.log("Deployments updated:", deploymentsArray.length);
                renderDeploymentReport();
            }, (error) => console.error("Error fetching deployments:", error));
        }

        // --- 3. DATA RENDERING AND JOINING (Re-integrates the logic to connect the tables) ---
        function renderDeploymentReport() {
            const container = document.getElementById('report-container');

            if (!isAuthReady) {
                container.innerHTML = `<div class="alert alert-info text-center" role="alert">ডাটা লোড হচ্ছে...</div>`;
                return;
            }

            // 1. Join the flat deployment data with parent Application and Environment data
            const joinedDeployments = [];

            // Sort deployments by created_at (newest first)
            const sortedDeployments = deploymentsArray.sort((a, b) => {
                const dateA = a.created_at instanceof Date ? a.created_at.getTime() : 0;
                const dateB = b.created_at instanceof Date ? b.created_at.getTime() : 0;
                return dateB - dateA;
            });

            sortedDeployments.forEach((deployment, index) => {
                const environment = environmentsMap[deployment.environment_id];

                let applicationName = 'Unknown Application';
                let environmentName = 'Unknown Environment';

                if (environment) {
                    environmentName = environment.name;
                    const application = applicationsMap[environment.application_id];
                    if (application) {
                        applicationName = application.name;
                    }
                }

                joinedDeployments.push({
                    index: index + 1,
                    application_name: applicationName,
                    environment_name: environmentName,
                    commit_hash: deployment.commit_hash || 'N/A',
                    created_at: deployment.created_at ? deployment.created_at.toLocaleString('en-US', {
                        year: 'numeric', month: 'short', day: 'numeric',
                        hour: '2-digit', minute: '2-digit'
                    }) : 'N/A Date'
                });
            });


            if (joinedDeployments.length === 0) {
                container.innerHTML = `
                    <div class="alert alert-warning text-center" role="alert">
                        আপনার ডাটাবেসে কোনো ডেপ্লয়মেন্ট ডেটা পাওয়া যায়নি।
                    </div>
                `;
                return;
            }

            // 2. Generate the Single Unified Table (using Bootstrap classes)

            let tableHTML = `
                <table class="table table-striped table-hover shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">অ্যাপ্লিকেশন নাম (Application)</th>
                            <th scope="col">এনভায়রনমেন্ট নাম (Environment)</th>
                            <th scope="col">কমিট হ্যাশ (Commit Hash)</th>
                            <th scope="col">ডেপ্লয়মেন্টের তারিখ (Date)</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            joinedDeployments.forEach((deployment) => {
                let badgeClass = 'bg-secondary';
                if (deployment.environment_name && deployment.environment_name.includes('Production')) {
                    badgeClass = 'bg-danger';
                } else if (deployment.environment_name && deployment.environment_name.includes('Staging')) {
                    badgeClass = 'bg-warning text-dark';
                } else if (deployment.environment_name && deployment.environment_name.includes('Development')) {
                    badgeClass = 'bg-info text-dark';
                }

                tableHTML += `
                    <tr>
                        <th scope="row">${deployment.index}</th>
                        <td>${deployment.application_name}</td>
                        <td>
                            <span class="badge ${badgeClass}">${deployment.environment_name}</span>
                        </td>
                        <td><code class="text-primary">${deployment.commit_hash}</code></td>
                        <td>${deployment.created_at}</td>
                    </tr>
                `;
            });

            tableHTML += `
                    </tbody>
                </table>
            `;

            container.innerHTML = tableHTML;
        }

        // Initial render while waiting for auth
        document.addEventListener('DOMContentLoaded', renderDeploymentReport);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        xintegrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>