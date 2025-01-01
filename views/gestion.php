

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lien du Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lien des Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    
    <title>Page de Gestion</title>
</head>
<body class="flex bg-gray-100 min-h-screen">
    <aside class="hidden sm:flex sm:flex-col">
        <a href="#" class="inline-flex items-center justify-center h-20 w-20 hover:bg-purple-500 focus:bg-purple-500">
            <img src="../assets/images/Shared_Horizons_Logo.png" alt="Site Web Logo" />
        </a>
        <div class="flex-grow flex flex-col justify-between text-gray-500 bg-gray-800">
        <nav class="flex flex-col mx-4 my-6 space-y-4">
            <a href="#" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
            <span class="sr-only">Folders</span>
            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
            </a>
            <a href="#" class="inline-flex items-center justify-center py-3 text-purple-600 bg-white rounded-lg">
            <span class="sr-only">Dashboard</span>
            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            </a>
            <a href="#" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
            <span class="sr-only">Messages</span>
            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            </a>
            <a href="#" class="inline-flex items-center justify-center py-3 hover:text-gray-400 hover:bg-gray-700 focus:text-gray-400 focus:bg-gray-700 rounded-lg">
            <span class="sr-only">Documents</span>
            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            </a>
        </nav>
        </div>
    </aside>
    <div class="flex-grow text-gray-800">
        <header class="flex items-center h-20 px-6 sm:px-10 bg-white">
            <div class="flex flex-shrink-0 items-center ml-auto">
                <div class="hidden md:flex md:flex-col md:items-end md:leading-tight">
                    <span class="font-semibold">Grace Simmons</span>
                    <span class="text-sm text-gray-600">Administrateur</span>
                </div>
                <span class="h-12 w-12 ml-2 sm:ml-3 mr-2 bg-gray-100 rounded-full overflow-hidden">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="user profile photo" class="h-full w-full object-cover">
                </span>
            
                <div class="border-l pl-3 ml-3 space-x-1">
                    <button class="relative p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600 rounded-full">
                    <a href="../public/logout.php">
                        <span class="sr-only">Log out</span>
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </a>
                    </button>
                </div>
            </div>
        </header>
        <main class="p-6 sm:p-10 space-y-6">
            <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
                <div class="mr-6">
                    <h1 class="text-4xl font-semibold mb-2">Dashboard</h1>
                    <h2 class="text-gray-600 ml-0.5">Mobile UX/UI Design course</h2>
                </div>
                <div class="flex flex-wrap items-start justify-end -mb-3">
                    <button class="inline-flex px-5 py-3 text-white bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 rounded-md ml-6 mb-3">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-white -ml-1 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create new Catégorie
                    </button>
                </div>
            </div>

            <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="flex items-center p-8 bg-white shadow rounded-lg">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-yellow-600 bg-yellow-100 rounded-full mr-6">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path fill="#fff" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path fill="#fff" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    </div>
                    <div>
                    <span class="block text-2xl font-bold">9</span>
                    <span class="block text-gray-500">Lecteurs</span>
                    </div>
                </div>
                <div class="flex items-center p-8 bg-white shadow rounded-lg">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-blue-600 bg-blue-100 rounded-full mr-6">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    </div>
                    <div>
                    <span class="block text-2xl font-bold">3</span>
                    <span class="block text-gray-500">Auteurs</span>
                    </div>
                </div>
                <div class="flex items-center p-8 bg-white shadow rounded-lg">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-green-600 bg-green-100 rounded-full mr-6">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    </div>
                    <div>
                    <span class="block text-2xl font-bold">6</span>
                    <span class="block text-gray-500">Articles</span>
                    </div>
                </div>
            </section>

            <section class="grid md:grid-cols-2 xl:grid-cols-4 xl:grid-rows-3 xl:grid-flow-col gap-6">
                <div class="flex items-center p-8 bg-white shadow rounded-lg">
                    <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-purple-600 bg-purple-100 rounded-full mr-6">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    </div>
                    <div>
                    <span class="block text-2xl font-bold">16</span>
                    <span class="block text-gray-500">Utilisateurs</span>
                    </div>
                </div>

                <div class="row-span-3 bg-white shadow rounded-lg">
                    <div class="flex items-center justify-between px-6 py-5 font-semibold border-b border-gray-100">
                    <span>Les Lecteurs</span>
                    
                    </div>
                    <div class="overflow-y-auto" style="max-height: 24rem;">
                        <ul class="p-6 space-y-6">
                            <li class="flex items-center">
                                <div class="h-10 w-10 mr-3 bg-gray-100 rounded-full overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/women/82.jpg" alt="Annette Watson profile picture">
                                </div>
                                <span class="text-gray-600">Annette Watson</span>
                                <span class="ml-auto font-semibold">9.3</span>
                            </li>
                            
                        </ul>
                    </div>
                </div>

                <div class="row-span-3 bg-white shadow rounded-lg">
                    <div class="flex items-center justify-between px-6 py-5 font-semibold border-b border-gray-100">
                    <span>Les Auteurs</span>
                    
                    </div>

                    <div class="overflow-y-auto" style="max-height: 24rem;">
                        <ul class="p-6 space-y-6">
                            <li class="flex items-center">
                            <div class="h-10 w-10 mr-3 bg-gray-100 rounded-full overflow-hidden">
                                <img src="https://randomuser.me/api/portraits/men/81.jpg" alt="Calvin Steward profile picture">
                            </div>
                            <span class="text-gray-600">Calvin Steward</span>
                            <span class="ml-auto font-semibold">8.9</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </section>
        </main>
    </div>
</body>
</html>
