<?php

require '../classes/Connexion.php';
require '../classes/Utilisateur.php';
require '../classes/Article.php';
require '../classes/Categorie.php';
require '../classes/Interaction.php';

session_start();

if(!isset($_SESSION['ID'])){
    header('location: ../public/login.php');
    exit();
}

$ID = $_SESSION['ID'];

$db = new DataBase();
$conn = $db->getConnection(); 

$auteur = new Utilisateur($conn);
$article = new Article($conn);
$categorie = new Categorie($conn);
$interaction = new Interaction($conn);

$posters = $article->getLecteurArticles();

$profile = $auteur->getProfileInfos($ID);

$auteur->setId($ID);

if ($profile) {
    $nom = $profile['Nom'];
    $prenom = $profile['Prenom'];
    $photo = $profile['Photo'];
    $role = $profile['Role'];
    $telephone = $profile['Telephone'];
    $email = $profile['Email'];
} else {

    echo "Profile non trouvé.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $auteur->setNom($nwnom = $_POST['nom']);
    $auteur->setPrenom($nwprenom = $_POST['prenom']);
    $auteur->setTelephone($nwtelephone = $_POST['telephone']);
    $auteur->setEmail($nwemail = $_POST['email']);
    $auteur->setMotDePasse($nwmot_de_passe = $_POST['password']);
    
    $auteur->setPhoto($nwphoto = null);
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = 'uploads/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $auteur->setPhoto($nwphoto = $newFileName);
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }

    $result = $auteur->updateProfile($ID, $nwnom, $nwprenom, $nwphoto, $nwtelephone, $nwemail, $nwmot_de_passe);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_article'])) {
    
    $article_id = $_POST['article_id'];
    $article->setTitre($titre = $_POST['titre']);
    $article->setContenu($contenu = $_POST['contenu']);
    $article->setCategorie($specialite = $_POST['specialite']);
    $article->setStatut('Accepté');
    $article->setDatePublication($date_publication = date("Y-m-d H:i:s"));
    
    $article->setImage($image = null);
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = 'uploads/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) { 
                $article->setImage($image = $newFileName);
                
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }

    $article->updateArticle($article_id);

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article'])) {
    $ID_article = $_POST['article_ID_Supp'] ?? null;
    if ($ID_article) {
        $article->deleteArticle($ID_article);
    }
}

$posters = $article->getAuteurArticles($ID);
$categoriess = $categorie->getAllCategorie();

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
    
    <title>Avocat - Profile</title>
</head>
<body class="bg-stone-300">

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
                            <a href="home_auteur.php" class="block py-2 pr-4 pl-3 text-stone-700 rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white" aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="profile_auteur.php" class="block py-2 pr-4 pl-3 text-stone-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Profile</a>
                        </li>
                        <li>
                            <a href="article_auteur.php" class="block py-2 pr-4 pl-3 text-stone-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Articles</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>

        <!-- Profile Form-->
        <div id="ctnrcsltion" class="hidden fixed left-[32rem] top-[0rem] flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <i id="xmarkcsltion" class="fa-solid fa-xmark ml-[26rem] text-2xl cursor-pointer mt-[1.2rem]" style="color: #2e2e2e;"></i>
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl mt-[-2rem] font-bold leading-tight tracking-tight text-stone-700 md:text-2xl dark:text-white">
                        Modifier Votre Profile
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="update_profile" value="1">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Nom</label>
                                <input type="text" name="nom" id="nom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                            </div>
                            <div>
                                <label for="prenom" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Prenom</label>
                                <input type="text" name="prenom" id="prenom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <label for="telephone" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Téléphone</label>
                                <input type="text" name="telephone" id="telephone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Email</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Password</label>
                                <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-stone-700 dark:text-white" for="photo">Photo de Profile</label>
                                <input name="photo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-[7px] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="file">
                            </div>
                        </div>
                        <button type="submit" class="ml-[7rem] w-[8rem] text-white bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 hover:bg-gradient-to-br font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Form Suppression-->
        <form id="supprimerArticle" method="POST" action="">
            <input type="hidden" name="delete_article" value="1">
            <input type="hidden" name="article_ID_Supp" id="article_ID_Supp" value="">
        </form>
        
        <!-- Post Form-->
        <div id="postform" class="hidden fixed left-[32rem] top-[0rem] flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:pr-4 dark:bg-gray-800 dark:border-gray-700">
                <i id="xmarkcsltion2" class="fa-solid fa-xmark ml-[26rem] text-2xl cursor-pointer mt-[1.2rem]" style="color: #2e2e2e;"></i>
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl mt-[-2rem] font-bold leading-tight tracking-tight text-stone-700 md:text-2xl dark:text-white">
                        Modifier votre Post 
                    </h1>
                    <form id="update-article-form" class="space-y-4 md:space-y-6" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="article_id" id="article_id">
                        <input type="hidden" name="update_article" value="1">
                        <div>
                            <label for="titre" class="block mb-2 text-sm font-medium text-stone-700 dark:text-white">Titre</label>
                            <input type="text" name="titre" id="titre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" >
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-stone-700 dark:text-white" for="image">Photo</label>
                            <input name="image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-[7px] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="file">
                        </div>
                        <div>
                            <label for="contenu" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contenu</label>
                            <textarea id="contenu" name="contenu" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Écrivez votre biographie ici..."></textarea>
                        </div>
                        <div>
                            <label for="specialite" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Spécialité </label>
                            <select id="specialite" name="specialite" class="bg-gray-50 border border-gray-300 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <?php foreach($categoriess as $categories){ ?>
                                <option value="<?php echo htmlspecialchars($categories['ID']) ?>"><?php echo htmlspecialchars($categories['Nom']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="ml-[7rem] w-[8rem] text-white bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 hover:bg-gradient-to-br font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Modifier</button>
                    </form>
                </div>
            </div>
        </div>


        <section>
            <div class="">
                <div class="container mx-auto py-8">
                    <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">

                        <div class="col-span-4 sm:col-span-3">
                            <div class="bg-white shadow rounded-lg p-6">
                                <div class="flex flex-col items-center">
                                    <img src='uploads/<?php echo $photo; ?>' class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">

                                    </img>
                                    <h1 class="text-xl font-bold"><?php echo $nom . ' ' . $prenom; ?></h1>
                                    <p class="text-lg text-stone-600 font-semibold"><?php echo $role; ?></p>
                                </div>
                                <button id="mdfiebttn" type="button" class="ml-[6.7rem] mt-[2.5rem] text-white bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 hover:bg-gradient-to-br font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Modifier</button>
                            </div>
                        </div>

                        <div class="col-span-4 sm:col-span-9">
                            <div class="bg-white shadow rounded-lg p-6">
                                <div class="w-full my-auto py-6 flex flex-col justify-center gap-2">
                                    <div class="w-full flex sm:flex-row xs:flex-col gap-2 justify-center">
                                        <div class="w-full">
                                            <dl class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                                                <div class="flex flex-col pb-3">
                                                    <dt class="mb-1 text-stone-900 font-bold text-base dark:text-gray-400">Nom</dt>
                                                    <dd class="text-lg text-stone-600 font-semibold"><?php echo $nom; ?></dd>
                                                </div>
                                                <div class="flex flex-col py-3">
                                                    <dt class="mb-1 text-stone-900 font-bold text-base dark:text-gray-400">Prenom</dt>
                                                    <dd class="text-lg text-stone-600 font-semibold"><?php echo $prenom; ?></dd>
                                                </div>
                                            </dl>
                                        </div>

                                        <div class="w-full">
                                            <dl class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                                                    <div class="flex flex-col pb-3">
                                                        <dt class="mb-1 text-stone-900 font-bold text-base dark:text-gray-400">Téléphone</dt>
                                                        <dd class="text-lg text-stone-600 font-semibold"><?php echo $telephone; ?></dd>
                                                    </div>
                                                    <div class="flex flex-col py-3">
                                                        <dt class="mb-1 text-stone-900 font-bold text-base dark:text-gray-400">Email</dt>
                                                        <dd class="text-lg text-stone-600 font-semibold"><?php echo $email; ?></dd>
                                                    </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            

            <?php foreach($posters as $poster){ ?>
            <!-- Post Card-->
            <div class="ml-[30rem] mb-[3rem] bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full p-8 transition-all duration-300 animate-fade-in pt-[3.5rem]">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-2/3 md:pl-8">
                        <p class="text-gray-700 font-semibold text-2xl dark:text-gray-300 mb-6"><?php echo htmlspecialchars($poster['Titre']) ?></p>
                        <div class="grid min-h-[140px] w-full place-items-center overflow-x-scroll rounded-lg lg:overflow-visible">
                            <img
                                class="object-cover object-center w-full h-96"
                                src="uploads/<?php echo $poster['Image'] ?>"
                                alt="Poster Image"
                            />
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-6 mt-6">
                            <?php echo htmlspecialchars($poster['Contenu']) ?>
                        </p>

                        <hr class="h-px my-4 bg-gray-200 border-0 dark:bg-gray-700">

                        <svg id="morecmnt" class="w-4 h-4 text-purple-700 cursor-pointer mb-[1rem]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 10">
                            <path d="M15.434 1.235A2 2 0 0 0 13.586 0H2.414A2 2 0 0 0 1 3.414L6.586 9a2 2 0 0 0 2.828 0L15 3.414a2 2 0 0 0 .434-2.179Z"/>
                        </svg>
                        <svg id="lesscmnt" class="w-4 h-4 text-purple-700 cursor-pointer mb-[1rem] hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 10 16">
                            <path d="M3.414 1A2 2 0 0 0 0 2.414v11.172A2 2 0 0 0 3.414 15L9 9.414a2 2 0 0 0 0-2.828L3.414 1Z"/>
                        </svg>
                    </div>

                    <div class="md:w-1/3 text-center mb-8 md:mb-0">
                        <h2 class="text-xl font-semibold text-purple-500 mb-4  mt-[3rem]">Catégorie</h2>
                        <p class="text-stone-700 font-semibold"><?php echo htmlspecialchars($poster['categorie_nom']) ?></p>
                        
                        <button id="mdfpost" data-article-id="<?php echo $poster['ID']; ?>" type="button" class="mt-[22rem] ml-[2rem] text-white bg-purple-700 hover:bg-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">Modifier</button>
                        <button onclick="getIdArticle(<?php echo $poster['ID']; ?>)" type="button" class="mt-[22rem] ml-[1rem] text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Supprimer</button>
                    </div>
                    
                </div>
                <div id="cmntsction" class="w-full flex-col justify-start items-start gap-8 flex hidden">
                    <?php   $comments = $interaction->getCommentsByArticle($poster['ID']);
                        foreach($comments as $comment) { ?>

                        <div class="w-full flex-col justify-start items-end gap-5 flex">
                            <div class="w-full p-6 bg-white rounded-2xl border border-gray-200 flex-col justify-start items-start gap-8 flex">
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
        const ctnr1 = document.getElementById("ctnrcsltion");
        const xmark1 = document.getElementById("xmarkcsltion");
        const bttnmdfie = document.getElementById("mdfiebttn");

        xmark1?.addEventListener('click', function(){
            ctnr1.classList.add('hidden');
        });

        bttnmdfie?.addEventListener('click', function(){
            ctnr1.classList.remove('hidden');
        });


        const ctnr2 = document.getElementById("postform");
        const xmark2 = document.getElementById("xmarkcsltion2");
        const mdfpostButtons = document.querySelectorAll('#mdfpost');

        mdfpostButtons.forEach(button => {
            button.addEventListener('click', function () {
                const articleId = this.getAttribute('data-article-id');
                
                document.getElementById('article_id').value = articleId;

                ctnr2.classList.remove('hidden');
            });
        });

        xmark2?.addEventListener('click', function () {
            ctnr2.classList.add('hidden');
        });


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

        function getIdArticle(article_ID_Supp) {
        document.getElementById("article_ID_Supp").value = article_ID_Supp;
        document.getElementById("supprimerArticle").submit();
        };


    </script>
</body>
</html>