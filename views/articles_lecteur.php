<?php

require '../classes/Connexion.php';
require '../classes/Article.php';
require '../classes/Interaction.php';

session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../public/login.php');
    exit();
}

$ID_lecteur = $_SESSION['ID'];

$db = new DataBase();
$conn = $db->getConnection();

$article = new Article($conn);
$interaction = new Interaction($conn);
$posters = $article->getLecteurArticles();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_comment'])) {

    $interaction->setIDLecteur($ID_lecteur);
    $interaction->setIDArticle($ID_article = $_POST['ID_article']);
    $interaction->setDescription($description = $_POST['description']);
    $interaction->setDataPublication($date_publication = date("Y-m-d H:i:s"));

    $interaction->addComment($ID_lecteur, $ID_article, $description, $date_publication);

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_like'])){
    $interaction->setIDLecteur($ID_lecteur);
    $interaction->setIDArticle($ID_article = $_POST['article_like']);

    $interaction->ajouterLike($ID_lecteur, $ID_article);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lien du Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lien des Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    
    <title>Articles</title>
</head>
<body class="bg-purple-200">

    <header>
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a class="flex items-center">
                    <img src="../assets/images/Shared_Horizons_Logo.png" class="mr-3 mt-[-1rem] w-[7rem]" alt="Site Web Logo" />
                </a>
                <div class="flex items-center lg:order-2 mt-[-1rem]">
                    <a href="../public/logout.php" class="text-white bg-purple-500 hover:opacity-80 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Logout</a>
                    <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1 mt-[-1rem]" id="mobile-menu-2">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="home_lecteur.php" class="block py-2 pr-4 pl-3 text-stone-700 rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white" aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="profile_lecteur.php" class="block py-2 pr-4 pl-3 text-stone-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Profile</a>
                        </li>
                        <li>
                            <a href="articles_lecteur.php" class="block py-2 pr-4 pl-3 text-stone-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Articles</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="flex rounded-md border-2 border-purple-400 mt-[2rem] overflow-hidden max-w-md mx-auto">
        <input type="email" placeholder="Search Something..."
          class="w-full outline-none bg-white text-gray-600 text-sm px-4 py-3" />
        <button type='button' class="flex items-center justify-center bg-purple-400  px-5">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" width="16px" class="fill-white">
            <path
              d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z">
            </path>
          </svg>
        </button>
    </div>

    <main>

        <section>

            <!-- Like Form-->
            <form id="ajouterlike" method="POST" >
                <input type="hidden" name="add_like" value="1">
                <input type="hidden" name="article_like" id="article_like" value="">
            </form>
            
            <!-- Post Card-->
            <?php foreach($posters as $poster) { ?>
            <div class="mt-[4rem] ml-[20rem] bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full p-8 transition-all duration-300 animate-fade-in pt-[3.5rem]">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 text-center mb-8 md:mb-0">
                        <img src="uploads/<?php echo $poster['auteur_photo']; ?>" alt="Profile Picture" class="rounded-full w-48 h-48 mx-auto mb-4 border-4 border-purple-500 transition-transform duration-300 hover:scale-105">
                        <h1 class="text-2xl font-bold text-purple-500 dark:text-white mb-2"></h1>
                        <p class="text-stone-700 font-semibold"><?php echo htmlspecialchars($poster['auteur_nom']) . ' ' . htmlspecialchars($poster['auteur_prenom']); ?></p>
                        

                        <h2 class="text-xl font-semibold text-purple-500 mb-4  mt-[3rem]">Catégorie</h2>
                        <p class="text-stone-700 font-semibold"><?php echo htmlspecialchars($poster['categorie_nom']) ?></p>
                        
                    </div>
                    <div class="md:w-2/3 md:pl-8">
                        <p class="text-gray-700 font-semibold text-2xl dark:text-gray-300 mb-6"> <?php echo htmlspecialchars($poster['Titre']) ?></p>
                        <div class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg lg:overflow-visible">
                            <img
                                class="object-cover object-center w-full h-96"
                                src="uploads/<?php echo $poster['Image'] ?>"
                                alt="nature image"
                            />
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-6 mt-6">
                            <?php echo htmlspecialchars($poster['Contenu']) ?>
                        </p>
                    </div>
                </div>

                <div class="w-full max-w-7xl px-4 md:px-5 lg:px-5 mx-auto">
                    <div class="w-full flex-col justify-start items-start lg:gap-10 gap-6 inline-flex">
                        <div class="w-full flex-col justify-start items-start lg:gap-9 gap-6 flex">
                            <div class="w-full relative flex justify-between gap-2">
                                <button onclick="getIdCommentaire(<?php echo $poster['ID']; ?>)" class="block items-center px-1 -ml-1 flex-column">
                                    <svg class="w-8 h-8 text-gray-600 cursor-pointer hover:text-purple-700" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                                        </path>
                                    </svg>
                                    <?php $nmbrlikes = $interaction->getLikeCount($poster['ID']);  ?>
                                    <span class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300"><?php echo $nmbrlikes ?></span>
                                </button>
                                <form method="POST" class="w-full">
                                    <input type="hidden" name="add_comment" value="1">
                                    <input type="hidden" name="ID_article" value="<?php echo $poster['ID']; ?>">
                                    <input type="text" name="description"
                                        class="w-full py-3 px-5 rounded-lg border border-gray-300 bg-white shadow-[0px_1px_2px_0px_rgba(16,_24,_40,_0.05)] focus:outline-none text-gray-900 placeholder-gray-400 text-sm font-normal leading-relaxed"
                                        placeholder="Write comments here....">
                                    <button type="submit" class="absolute right-6 top-[18px]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none">
                                            <path
                                                d="M11.3011 8.69906L8.17808 11.8221M8.62402 12.5909L8.79264 12.8821C10.3882 15.638 11.1859 17.016 12.2575 16.9068C13.3291 16.7977 13.8326 15.2871 14.8397 12.2661L16.2842 7.93238C17.2041 5.17273 17.6641 3.79291 16.9357 3.06455C16.2073 2.33619 14.8275 2.79613 12.0679 3.71601L7.73416 5.16058C4.71311 6.16759 3.20259 6.6711 3.09342 7.7427C2.98425 8.81431 4.36221 9.61207 7.11813 11.2076L7.40938 11.3762C7.79182 11.5976 7.98303 11.7083 8.13747 11.8628C8.29191 12.0172 8.40261 12.2084 8.62402 12.5909Z"
                                                stroke="#111827" stroke-width="1.6" stroke-linecap="round" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <div>
                                <hr class="h-px w-[50rem] my-4 bg-gray-200 border-0 dark:bg-gray-700">

                                <svg id="morecmnt" class="w-4 h-4 text-purple-700 cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 10">
                                    <path d="M15.434 1.235A2 2 0 0 0 13.586 0H2.414A2 2 0 0 0 1 3.414L6.586 9a2 2 0 0 0 2.828 0L15 3.414a2 2 0 0 0 .434-2.179Z"/>
                                </svg>
                                <svg id="lesscmnt" class="w-4 h-4 text-purple-700 cursor-pointer hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 10 16">
                                    <path d="M3.414 1A2 2 0 0 0 0 2.414v11.172A2 2 0 0 0 3.414 15L9 9.414a2 2 0 0 0 0-2.828L3.414 1Z"/>
                                </svg>
                            </div>
                            <div id="cmntsction" class="w-full flex-col justify-start items-start gap-8 flex hidden">
                                <?php   $comments = $interaction->getCommentsByArticle($poster['ID']);
                                foreach($comments as $comment) { ?>

                                    <div class="w-full flex-col justify-start items-end gap-5 flex">
                                        <div
                                            class="w-full p-6 bg-white rounded-2xl border border-gray-200 flex-col justify-start items-start gap-8 flex">
                                            <div class="w-full flex-col justify-center items-start gap-3.5 flex">
                                                <div class="w-full justify-between items-center inline-flex">
                                                    <div class="justify-start items-center gap-2.5 flex">
                                                        <div
                                                            class="w-10 h-10 bg-gray-300 rounded-full justify-start items-start gap-2.5 flex">
                                                            <img class="rounded-full object-cover" src="uploads/<?php echo $comment['lecteur_photo'] ?>"
                                                                alt="Lecteur image" />
                                                        </div>
                                                        <div class="flex-col justify-start items-start gap-1 inline-flex">
                                                            <h5 class="text-gray-900 text-sm font-semibold leading-snug">
                                                            <?php echo htmlspecialchars($comment['lecteur_nom']) ?>
                                                            </h5>
                                                            <h6 class="text-gray-500 text-xs font-normal leading-5"><?php echo htmlspecialchars($comment['commentaire_date']) ?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="w-6 h-6 relative">
                                                        <div class="w-full h-fit flex">
                                                            <div class="relative w-full">
                                                                <div class="absolute left-0 top-0 py-2.5 px-4 text-gray-300"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-gray-800 text-sm font-normal leading-snug"><?php echo htmlspecialchars($comment['commentaire_description']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            
        </section>
        
    </main>


    <footer class="bg-white rounded-lg shadow dark:bg-gray-900 m-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="../assets/images/Shared_Horizons_Logo.png" class="mb-[-2rem] w-[7rem]" alt="Flowbite Logo" />
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a href="https://oussamaamou.github.io/PortFolio-HTML-CSS-JS/" target="_blank" class="hover:underline me-4 md:me-6">About</a>
                    </li>
                    <li>
                        <a href="https://www.youcode.ma/" target="_blank" class="hover:underline me-4 md:me-6">Licensing</a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/in/oussama-amou-b71151337/" target="_blank" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="https://flowbite.com/" class="hover:underline">Shared Horizons</a>. Tous droits réservés.</span>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            const morecmntButtons = document.querySelectorAll("#morecmnt");
            const lesscmntButtons = document.querySelectorAll("#lesscmnt");
            const cmntSections = document.querySelectorAll("#cmntsction");

            morecmntButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    cmntSections[index].classList.remove('hidden');
                    button.classList.add('hidden'); 
                    lesscmntButtons[index].classList.remove('hidden');
                });
            });

            lesscmntButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    cmntSections[index].classList.add('hidden');
                    button.classList.add('hidden'); 
                    morecmntButtons[index].classList.remove('hidden');
                });
            });
        });

        function getIdCommentaire(article_like) {
        document.getElementById("article_like").value = article_like;
        document.getElementById("ajouterlike").submit();
        };

        
    </script>
</body>
</html>