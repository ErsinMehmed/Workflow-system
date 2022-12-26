<?php
session_start();

include '../action/dbconn.php';

$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="bg" class="overflow-x-hidden">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="shortcut icon" href="../images/title.png" />
  <link href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
  <link rel="stylesheet" href="../css/app.css" />
  <link rel="stylesheet" href="../css/alert.css" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

  <title>Carpet Cleaning - Акаунт</title>
</head>

<body>
  <section>
    <div id="app">
      <!--Scroll detector-->
      <div class="w-full h-1 rounded-r-full fixed z-40 top-0 left-0 bg-blue-400" :style="{ width: progress }"></div>

      <!--Scroll to top button-->
      <div class="fixed z-30 right-4 bottom-4 w-10 h-10 hidden bg-blue-500 hover:bg-blue-600 lg:flex rounded-full justify-center items-center cursor-pointer transition-all" style="
            box-shadow: rgb(0 0 0 / 25%) 0px 14px 28px,
              rgb(0 0 0 / 22%) 0px 10px 10px;
          " v-show="scY > 300" @click="goTop">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-7 h-7 rounded-full -mt-0.5 text-white">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
      </div>

      <!--Message toast-->
      <div v-show="imagePreview != null && documentSection" id="toast-message" class="hidden md:flex fixed bottom-4 right-4 items-center p-4 w-full max-w-sm text-gray-500 bg-white rounded-lg shadow-xl border border-slate-50" :class="{'right-4': scY < 300, 'right-16': scY > 300}" role="alert">
        <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-500 bg-green-100 rounded-lg">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
          </svg>
        </div>
        <div class="ml-3 text-sm font-normal">
          Натиснете върху снимката за да я смените.
        </div>
        <button type="button" class="bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:outline-none focus:ring-0 p-1.5 hover:bg-gray-50 inline-flex h-8 w-8" data-dismiss-target="#toast-message" aria-label="Close">
          <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>

      <!--Navbar section start-->
      <nav class="bg-white border-b border-slate-200 shadow-md sm:px-0 pt-3 md:py-3 top-0 sticky z-30">
        <div class="bg-white flex flex-wrap sm:px-5 md:px-6 lg:px-12 pb-3 md:pb-0 items-center justify-between">
          <a href="home.php" class="flex items-center pl-5 sm:pl-0">
            <img src="../images/main-logo.png" class="h-7 mr-3 md:h-12" alt="Main logo" />
          </a>
          <div class="flex items-center pr-5 sm:pr-0">
            <?php
            $query = "SELECT * FROM customer WHERE email = '$email'";
            $query_run = mysqli_query($con, $query);

            while ($rows = mysqli_fetch_array($query_run)) {
              if ($rows["image"] != "") {
            ?>
                <img src="../action/customer-images/<?= $rows["image"] ?>" alt="" class="w-8 h-8 cursor-pointer hover:opacity-75 transition-all
              rounded-full object-cover md:hidden active:scale-90 updatePhoto">
              <?php
              } else {
              ?>
                <img src="../images/user.png" alt="" class="w-8 h-8 cursor-pointer hover:opacity-75 transition-all rounded-full object-cover md:hidden active:scale-90" />
            <?php
              }
            } ?>
            <img class="w-8 h-8 object-cover cursor-pointer hover:opacity-75 transition-all rounded-full md:hidden ml-2.5 mr-1" src="../images/britain-flag.png" alt="english" />
            <button @click="hamburgerIcon = !hamburgerIcon" id="open-nav-bar" data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 pr-0 text-sm text-gray-500 rounded-lg md:hidden focus:outline-none focus:ring-0 transition-all" aria-controls="navbar-default" aria-expanded="false">
              <svg v-show="hamburgerIcon" class="w-8 h-8" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
              </svg>
              <svg v-show="!hamburgerIcon" fill="none" viewBox="0 0 24 24" stroke-width="2.4" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="hidden w-full md:block md:w-auto relative" id="navbar-default">
            <ul class="flex flex-col -mb-3 md:-mb-0.5 p-4 mt-4 border border-gray-100 md:rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-lg md:font-semibold md:border-0 md:bg-white">
              <li>
                <a href="home.php" class="flex items-center py-2 pl-3 pr-4 text-gray-700 rounded-md hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 transition-all active:scale-90">
                  <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 md:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                  </svg>
                  Начало
                </a>
              </li>
              <li>
                <a href="#" class="flex items-center py-2 pl-3 pr-4 text-gray-700 rounded-md hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 transition-all active:scale-90">
                  <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 md:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  Услуги
                </a>
              </li>
              <li>
                <a href="#" class="flex items-center py-2 pl-3 pr-4 text-gray-700 rounded-md hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 transition-all active:scale-90">
                  <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 md:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                  </svg>
                  За нас
                </a>
              </li>
              <li>
                <a href="#" class="flex items-center py-2 pl-3 pr-4 text-gray-700 rounded-md hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 transition-all active:scale-90">
                  <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 md:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                  </svg>
                  Контакти
                </a>
              </li>
              <?php
              $query = "SELECT * FROM customer WHERE email = '$email'";
              $query_run = mysqli_query($con, $query);

              while ($rows = mysqli_fetch_array($query_run)) {
                if ($rows["image"] != "") {
              ?>
                  <li>
                    <img src="../action/customer-images/<?= $rows["image"] ?>" alt="" class="w-8 h-8 cursor-pointer hover:opacity-75
                  transition-all rounded-full object-cover hidden md:block
                  active:scale-90 updatePhoto ">
                  </li>
                <?php
                } else {
                ?>
                  <li>
                    <img src="../images/user.png" alt="" class="w-8 h-8 cursor-pointer hover:opacity-75 transition-all rounded-full object-cover hidden md:block active:scale-90" />
                  </li>
              <?php
                }
              } ?>
              <li>
                <img class="w-8 h-8 object-cover cursor-pointer hover:opacity-75 transition-all rounded-full hidden md:block active:scale-90" src="../images/britain-flag.png" alt="english" />
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!--Main section-->
      <div class="h-screen md:h-full md:mt-10 w-full md:flex md:justify-center md:items-center md:my-10">
        <div class="w-full md:w-[50rem] lg:w-[55rem] xl:w-[65rem] 2xl:w-[66rem] md:shadow-xl py-6 px-6 md:py-8 md:px-10 md:rounded-xl md:border border-slate-50 md:flex md:space-x-10">
          <div class="w-full md:w-[20%]">
            <ul class="flex justify-between md:block md:space-y-3 text-slate-600 font-semibold sm:px-6 md:px-0 pb-3 md:pb-4 md:pb-0 md:mt-0">
              <li @click="accountSection = true; passowrdSection = false;  historySection= false; documentSection = false; orderSection = false" :class="accountSection ? 'text-slate-700 bg-[#deebfd] hover:bg-[#d1e4ff]' : 'bg-white hover:bg-[#deebfd] hover:text-slate-700'" class="flex items-center justify-center md:justify-start py-3 md:py-1.5 px-3 md:pl-3 transition-all rounded-xl cursor-pointer active:scale-90">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-5 md:h-5 md:mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="hidden md:block">Акаунт</span>
              </li>
              <li @click="passowrdSection = true; accountSection = false;  historySection = false; documentSection = false; orderSection = false" :class="passowrdSection ? 'text-slate-700 bg-[#deebfd] hover:bg-[#d1e4ff]' : 'bg-white hover:bg-[#deebfd] hover:text-slate-700'" class="flex items-center justify-center md:justify-start py-3 md:py-1.5 px-3 md:pl-3 transition-all rounded-xl cursor-pointer active:scale-90">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-5 md:h-5 md:mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <span class="hidden md:block">Парола</span>
              </li>
              <li @click=" historySection = true; accountSection = false;  passowrdSection = false; documentSection = false; orderSection = false" :class=" historySection ? 'text-slate-700 bg-[#deebfd] hover:bg-[#d1e4ff]' : 'bg-white hover:bg-[#deebfd] hover:text-slate-700'" class="flex items-center justify-center md:justify-start py-3 md:py-1.5 px-3 md:pl-3 transition-all rounded-xl cursor-pointer active:scale-90">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-5 md:h-5 md:mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="hidden md:block">История</span>
              </li>
              <li @click="documentSection = true; accountSection = false;  passowrdSection = false; historySection = false; orderSection = false" :class="documentSection ? 'text-slate-700 bg-[#deebfd] hover:bg-[#d1e4ff]' : 'bg-white hover:bg-[#deebfd] hover:text-slate-700'" class="flex items-center justify-center md:justify-start py-3 md:py-1.5 px-3 md:pl-3 transition-all rounded-xl cursor-pointer active:scale-90">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-5 md:h-5 md:mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                </svg>
                <span class="hidden md:block">Документи</span>
              </li>
              <li @click="orderSection = true; documentSection = false; accountSection = false;  passowrdSection = false; historySection = false" :class=" orderSection ? 'text-slate-700 bg-[#deebfd] hover:bg-[#d1e4ff]' : 'bg-white hover:bg-[#deebfd] hover:text-slate-700'" class="flex items-center justify-center md:justify-start py-3 md:py-1.5 px-3 md:pl-3 transition-all rounded-xl cursor-pointer active:scale-90">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-5 md:h-5 md:mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                <span class="hidden md:block">Поръчка</span>
              </li>
              <li id="log-out" class="flex items-center justify-center md:justify-start py-3 md:py-1.5 px-3 md:pl-3 transition-all rounded-xl cursor-pointer active:scale-90 bg-white hover:bg-[#deebfd] hover:text-slate-700">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 md:w-5 md:h-5 md:mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                <span class="hidden md:block">Изход</span>
              </li>
            </ul>
          </div>

          <!--Account section-->
          <div v-show="accountSection" class="w-full md:w-[80%] shadow-lg rounded-xl border border-slate-50 p-6 md:p-8 text-slate-700">
            <h1 class="font-bold text-2xl mb-6 md:mb-8 text-center sm:text-left">
              Акаунт
            </h1>
            <div class="font-bold sm:ml-4 mb-2 text-center sm:text-left">
              Снимка
            </div>
            <?php
            $query = "SELECT * FROM customer WHERE email = '$email'";
            $query_run = mysqli_query($con, $query);

            while ($rows = mysqli_fetch_array($query_run)) {
            ?>
              <div class="sm:flex items-center sm:space-x-4">
                <?php if ($rows["image"] != "") { ?>
                  <img class="object-fill w-24 h-24 rounded-full shadow-lg mx-auto
                sm:mx-0 updatePhoto" :src="profileImgPreview ? profileImgPreview
                : '../action/customer-images/<?= $rows["image"] ?>'" alt="Profile photo" />
                <?php } else { ?>
                  <img class="object-fill w-24 h-24 rounded-full shadow-lg mx-auto sm:mx-0" :src="profileImgPreview ? profileImgPreview : '../images/user.png'" alt="Profile photo" />
                <?php } ?>

                <form id="customer-image-form">
                  <div class="sm:inline-flex sm:gap-x-4 space-y-4 sm:space-y-0 mt-3 sm:mt-0">
                    <button v-show="profileImgPreview != null" @click="profileImgPreview = null" type="submit" class="w-full block py-2 px-6 text-sm font-bold text-white focus:outline-none bg-blue-500 rounded-lg shadow-md border border-blue-500 hover:bg-blue-600 transition-all active:scale-90">
                      Запази
                    </button>
                    <input type="hidden" id="getCutomerEmail" name="customerEmail" value="<?= $email ?>" />
                    <label class="w-full block py-2 px-6 text-sm font-bold text-blue-600 hover:text-blue-700 focus:outline-none bg-white rounded-lg shadow-md border border-gray-100 hover:bg-gray-50 transition-all active:scale-90 cursor-pointer" for="profile-photo-input">
                      <div class="text-center">Избери</div>
                      <input @change="profilePhotoUpdate" id="profile-photo-input" name="customerImage" type="file" class="hidden" accept="image/png, image/jpg, image/jpeg" />
                    </label>
                  </div>
                </form>
              </div>
              <hr class="w-full my-5 sm:my-6" />
              <form id="user-info-form">
                <div class="sm:flex items-center sm:space-x-5 space-y-4 sm:space-y-0">
                  <div class="sm:w-1/2">
                    <label for="full-name" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                      Име
                    </label>
                    <input type="text" id="full-name" value="<?= $rows['name'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" readonly />
                  </div>
                  <div class="sm:w-1/2">
                    <label for="username" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                      Потребителско име
                    </label>
                    <input type="text" name="username" id="username" value="<?= $rows['username'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-0 focus:border-gray-400 w-full p-2.5" placeholder="Потребителско име" />
                  </div>
                </div>
                <hr class="w-full mt-6 mb-5 sm:mt-7 sm:mb-6" />
                <div class="sm:flex items-center sm:space-x-5 space-y-4 sm:space-y-0">
                  <div class="sm:w-1/2">
                    <label for="userEmail" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                      Имейл
                    </label>
                    <input id="userEmail" name="userEmail" value="<?= $rows['email'] ?>" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" readonly />
                  </div>
                  <div class="sm:w-1/2">
                    <label for="phone-number" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                      Телефонен номер
                    </label>
                    <input type="text" id="phone-number" name="phoneAccount" value="<?= $rows['phone'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-0 focus:border-gray-400 w-full p-2.5" placeholder="Въведете телефон" />
                  </div>
                </div>
                <div class="sm:flex items-center sm:space-x-5 space-y-4 sm:space-y-0 mt-4">
                  <div class="sm:w-1/2">
                    <label for="city" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                      Град
                    </label>
                    <?php if ($rows['city'] == "") { ?>
                      <select id="city" name="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-0 focus:border-gray-400 block w-full p-2.5">
                        <option v-for="city in cities" :value="city.name">
                          {{city.name}}
                        </option>
                      </select>
                    <?php } else { ?>
                      <input readonly type="text" name="city" value="<?= $rows['city'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 cursor-not-allowed" />
                    <?php } ?>
                  </div>
                  <div class="sm:w-1/2">
                    <label for="address" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                      Адрес
                    </label>
                    <input type="text" name="address" id="address" value="<?= $rows['address'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-0 focus:border-gray-400 w-full p-2.5" placeholder="Въведете адрес" />
                  </div>
                </div>
                <hr class="w-full mt-7 mb-6" />
                <div class="w-full text-slate-700">
                  <div class="text-sm font-semibold">Линкове към акунти</div>
                  <div class="text-xs font-semibold text-slate-400">
                    Ние Ви позволяваме да се регистрирате по-лесно без да губите
                    време
                  </div>
                </div>
                <div class="flex justify-between items-center mt-4">
                  <div class="flex items-center">
                    <svg viewBox="0 0 24 24" class="w-8 h-8">
                      <path fill="#EA4335" d="M5.26620003,9.76452941 C6.19878754,6.93863203 8.85444915,4.90909091 12,4.90909091 C13.6909091,4.90909091 15.2181818,5.50909091 16.4181818,6.49090909 L19.9090909,3 C17.7818182,1.14545455 15.0545455,0 12,0 C7.27006974,0 3.1977497,2.69829785 1.23999023,6.65002441 L5.26620003,9.76452941 Z" />
                      <path fill="#34A853" d="M16.0407269,18.0125889 C14.9509167,18.7163016 13.5660892,19.0909091 12,19.0909091 C8.86648613,19.0909091 6.21911939,17.076871 5.27698177,14.2678769 L1.23746264,17.3349879 C3.19279051,21.2936293 7.26500293,24 12,24 C14.9328362,24 17.7353462,22.9573905 19.834192,20.9995801 L16.0407269,18.0125889 Z" />
                      <path fill="#4A90E2" d="M19.834192,20.9995801 C22.0291676,18.9520994 23.4545455,15.903663 23.4545455,12 C23.4545455,11.2909091 23.3454545,10.5272727 23.1818182,9.81818182 L12,9.81818182 L12,14.4545455 L18.4363636,14.4545455 C18.1187732,16.013626 17.2662994,17.2212117 16.0407269,18.0125889 L19.834192,20.9995801 Z" />
                      <path fill="#FBBC05" d="M5.27698177,14.2678769 C5.03832634,13.556323 4.90909091,12.7937589 4.90909091,12 C4.90909091,11.2182781 5.03443647,10.4668121 5.26620003,9.76452941 L1.23999023,6.65002441 C0.43658717,8.26043162 0,10.0753848 0,12 C0,13.9195484 0.444780743,15.7301709 1.23746264,17.3349879 L5.27698177,14.2678769 Z" />
                    </svg>
                    <div class="text-slate-500 text-sm font-semibold ml-2">
                      Впишете се с Google
                    </div>
                  </div>
                  <button type="button" class="py-1.5 px-4 sm:px-6 text-sm font-bold text-blue-600 hover:text-blue-700 focus:outline-none bg-white rounded-lg shadow-md border border-gray-100 hover:bg-gray-50 transition-all active:scale-90">
                    Свързване
                  </button>
                </div>
                <div class="flex justify-between items-center mt-6">
                  <div class="flex items-center">
                    <svg class="w-8 h-8" viewBox="0 0 291.319 291.319" style="enable-background: new 0 0 291.319 291.319">
                      <path style="fill: #3b5998" d="M145.659,0c80.45,0,145.66,65.219,145.66,145.66c0,80.45-65.21,145.659-145.66,145.659
		                    S0,226.109,0,145.66C0,65.219,65.21,0,145.659,0z" />
                      <path style="fill: #ffffff" d="M163.394,100.277h18.772v-27.73h-22.067v0.1c-26.738,0.947-32.218,15.977-32.701,31.763h-0.055
                        v13.847h-18.207v27.156h18.207v72.793h27.439v-72.793h22.477l4.342-27.156h-26.81v-8.366
                        C154.791,104.556,158.341,100.277,163.394,100.277z" />
                    </svg>
                    <div class="text-slate-500 text-sm font-semibold ml-2">
                      Впишете се с Facebook
                    </div>
                  </div>
                  <button type="button" class="py-1.5 px-4 sm:px-6 text-sm font-bold text-blue-600 hover:text-blue-700 focus:outline-none bg-white rounded-lg shadow-md border border-gray-100 hover:bg-gray-50 transition-all active:scale-90">
                    Свързване
                  </button>
                </div>
                <hr class="w-full mt-7 mb-6" />
                <div class="sm:flex justify-end">
                  <button type="submit" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-0 font-semibold rounded-lg text-sm px-5 py-2.5 transition-all active:scale-90">
                    Запази промените
                  </button>
                </div>
              <?php
            }
              ?>
              </form>
          </div>

          <!--Passowrd section-->
          <div v-show="passowrdSection" class="md:w-[80%] shadow-lg rounded-xl border border-slate-50 p-6 md:p-8 text-slate-700">
            <h1 class="font-bold text-2xl mb-6 md:mb-8 text-center sm:text-left">
              Парола
            </h1>
            <div class="font-semibold mb-1 sm:mb-2 text-slate-500 text-sm md:text-base text-center sm:text-left">
              Не сте сигурни, че акаунта Ви е защитен? Сменете паролата си!
            </div>
            <form id="update-customer-password">
              <div class="w-full mt-6">
                <div class="sm:w-1/2 pr-2.5">
                  <input type="hidden" value="<?= $email ?>" name="customerEmail" />
                  <label for="old-password" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                    Стара парола
                  </label>
                  <input type="password" id="old-password" name="oldPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-0 focus:border-gray-400 w-full p-2.5" placeholder="••••••••••" />
                </div>
              </div>
              <hr class="w-full my-5 sm:my-6" />
              <div class="sm:flex items-center sm:space-x-5 space-y-4 sm:space-y-0">
                <div class="sm:w-1/2">
                  <label for="full-name" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                    Нова парола
                  </label>
                  <input type="password" minlength="8" id="full-name" name="newPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-0 focus:border-gray-400 w-full p-2.5" placeholder="••••••••••" />
                </div>
                <div class="sm:w-1/2">
                  <label for="passwordRep" class="block ml-1 mb-1 text-sm font-semibold text-slate-700">
                    Повторете парола
                  </label>
                  <input type="password" minlength="8" id="passwordRep" name="newPasswordRep" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-0 focus:border-gray-400 w-full p-2.5" placeholder="••••••••••" />
                </div>
              </div>
              <div class="sm:flex justify-end mt-6">
                <button type="submit" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-0 font-semibold rounded-lg text-sm px-5 py-2.5 transition-all active:scale-90">
                  Запази промените
                </button>
              </div>
            </form>
          </div>

          <!--History section-->
          <div v-show="historySection" class="md:w-[80%] shadow-lg rounded-xl border border-slate-50 p-6 md:p-8 text-slate-700">
            <h1 class="font-bold text-2xl mb-6 md:mb-8 text-center sm:text-left">
              История на поръчките
            </h1>
            <div class="font-semibold mb-1 sm:mb-2 text-slate-500 text-sm md:text-base text-center sm:text-left">
              Тук можете да прегледате всички ваши поръчки към днешна дата.
            </div>
            <div class="flex items-center justify-center space-x-5 space-y-5 mt-8 w-full">
              <div class="grid gap-12 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 w-full">
                <!-- 1 card -->
                <div class="relative bg-white py-4 px-5 rounded-3xl w-full sm:w-56 md:w-80 lg:w-64 shadow-xl border border-slate-50 hover:bg-slate-50 transition-all">
                  <div class="text-white flex items-center absolute rounded-full p-3 shadow-xl bg-blue-50 border border-blue-100 left-4 -top-6">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7 text-blue-400">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                  </div>
                  <div class="mt-5">
                    <p class="text-xl font-semibold my-2">Основна</p>
                    <div class="flex text-gray-400 text-sm">
                      <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <p>Варна</p>
                    </div>
                    <div class="flex space-x-2 text-gray-400 text-sm my-3">
                      <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <p>134.80 лв.</p>
                    </div>
                    <div class="flex space-x-2 text-gray-400 text-sm my-3">
                      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <p>25.12.2022</p>
                    </div>
                    <div class="border-t-2"></div>
                    <div class="">
                      <div class="my-2">
                        <p class="font-semibold text-base mb-2">Екип</p>
                        <div class="space-y-2">
                          <div class="flex items-center">
                            <img src="https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="w-6 h-6 rounded-full mr-1.5" />
                            <div class="font-semibold text-slate-700">
                              Иван Стормев
                            </div>
                          </div>
                          <div class="flex items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxSqK0tVELGWDYAiUY1oRrfnGJCKSKv95OGUtm9eKG9HQLn769YDujQi1QFat32xl-BiY&usqp=CAU" class="w-6 h-6 rounded-full mr-1.5" />
                            <div class="font-semibold text-slate-700">
                              Виктор Ковачев
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 1 card -->
                <div class="relative bg-white py-4 px-5 rounded-3xl w-full sm:w-56 md:w-80 lg:w-64 shadow-xl border border-slate-50 hover:bg-slate-50 transition-all">
                  <div class="text-white flex items-center absolute rounded-full p-3 shadow-xl bg-orange-50 border border-orange-100 left-4 -top-6">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-7 w-7 text-orange-400">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                  </div>
                  <div class="mt-5">
                    <p class="text-xl font-semibold my-2">Премиум</p>
                    <div class="flex text-gray-400 text-sm">
                      <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <p>Варна</p>
                    </div>
                    <div class="flex space-x-2 text-gray-400 text-sm my-3">
                      <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <p>134.80 лв.</p>
                    </div>
                    <div class="flex space-x-2 text-gray-400 text-sm my-3">
                      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <p>25.12.2022</p>
                    </div>
                    <div class="border-t-2"></div>
                    <div class="">
                      <div class="my-2">
                        <p class="font-semibold text-base mb-2">Екип</p>
                        <div class="space-y-2">
                          <div class="flex items-center">
                            <img src="https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="w-6 h-6 rounded-full mr-1.5" />
                            <div class="font-semibold text-slate-700">
                              Иван Стормев
                            </div>
                          </div>
                          <div class="flex items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxSqK0tVELGWDYAiUY1oRrfnGJCKSKv95OGUtm9eKG9HQLn769YDujQi1QFat32xl-BiY&usqp=CAU" class="w-6 h-6 rounded-full mr-1.5" />
                            <div class="font-semibold text-slate-700">
                              Виктор Ковачев
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 1 card -->
                <div class="relative bg-white py-4 px-5 rounded-3xl w-full sm:w-56 md:w-80 lg:w-64 shadow-xl border border-slate-50 hover:bg-slate-50 transition-all">
                  <div class="text-white flex items-center absolute rounded-full p-3 shadow-xl bg-red-50 border border-red-100 left-4 -top-6">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7 text-red-400">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                    </svg>
                  </div>
                  <div class="mt-5">
                    <p class="text-xl font-semibold my-2">Вип</p>
                    <div class="flex text-gray-400 text-sm">
                      <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                      <p>Варна</p>
                    </div>
                    <div class="flex space-x-2 text-gray-400 text-sm my-3">
                      <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <p>134.80 лв.</p>
                    </div>
                    <div class="flex space-x-2 text-gray-400 text-sm my-3">
                      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <p>25.12.2022</p>
                    </div>
                    <div class="border-t-2"></div>
                    <div class="">
                      <div class="my-2">
                        <p class="font-semibold text-base mb-2">Екип</p>
                        <div class="space-y-2">
                          <div class="flex items-center">
                            <img src="https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="w-6 h-6 rounded-full mr-1.5" />
                            <div class="font-semibold text-slate-700">
                              Иван Стормев
                            </div>
                          </div>
                          <div class="flex items-center">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxSqK0tVELGWDYAiUY1oRrfnGJCKSKv95OGUtm9eKG9HQLn769YDujQi1QFat32xl-BiY&usqp=CAU" class="w-6 h-6 rounded-full mr-1.5" />
                            <div class="font-semibold text-slate-700">
                              Виктор Ковачев
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--Documents section-->
          <div v-show="documentSection" class="md:w-[80%] shadow-lg rounded-xl border border-slate-50 p-6 md:p-8 text-slate-700">
            <h1 class="font-bold text-2xl mb-6 md:mb-8 text-center sm:text-left">
              Документи
            </h1>
            <div class="font-semibold mb-1 sm:mb-2 text-slate-500 text-sm md:text-base text-center sm:text-left">
              Можете да добавите снимка или карта на обекта си за Ви
              предоставим най-добите услиги. В тази секция можете да откриете
              и фактурите си (ако сте заявили).
            </div>
            <form action="">
              <div class="w-full mt-6">
                <div class="ml-1 mb-1.5 font-semibold text-sm">
                  Снимка на обект
                </div>
                <div class="flex items-center justify-center w-full">
                  <label for="photo-file" class="flex flex-col items-center justify-center group w-full h-48 md:h-44 lg:h-40 2xl:h-36 border-2 border-gray-300 hover:border-blue-200 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-blue-50 transition-all">
                    <div v-show="imagePreview == null" class="flex flex-col items-center justify-center pt-5 pb-6">
                      <svg aria-hidden="true" class="w-10 h-10 mb-2 text-gray-400 group-hover:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                      </svg>
                      <p class="mb-2 text-sm text-gray-500 group-hover:text-blue-400">
                        <span class="font-semibold">
                          Натиснете за да добавите файл
                        </span>
                      </p>
                      <p class="text-xs text-gray-500 group-hover:text-blue-400">
                        PNG, JPG или JPEG (МАКС. 2MB)
                      </p>
                    </div>
                    <div v-show="imagePreview != null" class="w-full border-2 border-blue-200 border-dashed rounded-lg">
                      <img class="h-48 md:h-44 lg:h-40 2xl:h-36 w-full object-cover rounded-lg" :src="imagePreview" />
                    </div>
                    <input id="photo-file" @change="onFileChange" type="file" class="hidden" accept="image/png, image/jpg, image/jpeg" />
                  </label>
                </div>
                <div v-show="imagePreview != null" class="md:hidden w-full my-2.5 text-center text-sm">
                  Натиснете върху снимката за да я смените.
                </div>
                <div class="sm:flex justify-end mt-3">
                  <button type="submit" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-0 font-semibold rounded-lg text-sm px-5 py-2.5 transition-all active:scale-90">
                    Запази промените
                  </button>
                </div>
              </div>
            </form>
            <hr class="w-full my-5" />
            <div class="w-full">
              <div class="ml-1 mb-2.5 font-semibold text-sm">Фактури</div>
              <div class="flex items-center w-full space-x-8">
                <div class="px-4 py-2 rounded-lg shadow-xl bg-white flex justify-center items-center border border-slate-100">
                  <div>
                    <svg viewBox="0 0 512 512" style="enable-background: new 0 0 512 512" class="w-12 h-12 lg:w-16 lg:h-16 mx-auto mb-1">
                      <circle style="fill: #a7cefc" cx="256" cy="256" r="256" />
                      <path style="fill: #a7cefc" d="M508.497,298.324L373.226,163.052l-103.291,104.01L145.67,402.101l109.894,109.894
                        c0.147,0,0.291,0.005,0.436,0.005C382.966,512,488.324,419.566,508.497,298.324z" />
                      <polygon style="fill: #f4e3c3" points="299.386,89.212 145.67,89.212 145.67,402.101 373.226,402.101 373.226,163.052 " />
                      <polygon style="fill: #fed8b2" points="373.226,163.052 299.386,89.212 254.85,89.212 254.85,402.101 373.226,402.101 " />
                      <polygon style="fill: #ffd15d" points="299.386,163.052 373.226,163.052 299.386,89.212 " />
                      <rect x="211.178" y="188.768" style="fill: #f9b54c" width="128.431" height="6.896" />
                      <rect x="168.943" y="188.768" style="fill: #f9b54c" width="28.444" height="6.896" />
                      <rect x="211.178" y="217.212" style="fill: #f9b54c" width="128.431" height="6.896" />
                      <rect x="168.943" y="217.212" style="fill: #f9b54c" width="28.444" height="6.896" />
                      <rect x="211.178" y="245.657" style="fill: #f9b54c" width="128.431" height="6.896" />
                      <rect x="168.943" y="245.657" style="fill: #f9b54c" width="28.444" height="6.896" />
                      <rect x="211.178" y="274.101" style="fill: #f9b54c" width="128.431" height="6.896" />
                      <rect x="168.943" y="274.101" style="fill: #f9b54c" width="28.444" height="6.896" />
                      <rect x="237.899" y="343.488" style="fill: #f9b54c" width="56.889" height="6.896" />

                      <rect x="254.845" y="188.768" style="fill: #f4a200" width="84.764" height="6.896" />
                      <rect x="254.845" y="217.212" style="fill: #f4a200" width="84.764" height="6.896" />
                      <rect x="254.845" y="245.657" style="fill: #f4a200" width="84.764" height="6.896" />
                      <rect x="254.845" y="274.101" style="fill: #f4a200" width="84.764" height="6.896" />
                      <rect x="254.845" y="343.488" style="fill: #f4a200" width="39.943" height="6.896" />
                      <path style="fill: #f4a200" d="M340.34,334.932c1.5,0,2.717-1.217,2.717-2.717v-1.857c0-5.627-5.32-10.214-11.936-10.393v-0.71
                        c0-1.5-1.217-2.717-2.717-2.717c-1.5,0-2.717,1.217-2.717,2.717v0.71c-6.616,0.179-11.936,4.765-11.936,10.393v3.713
                        c0,5.627,5.32,10.214,11.936,10.392v13.665c-3.562-0.155-6.501-2.36-6.501-4.96v-1.857c0-1.5-1.217-2.717-2.717-2.717
                        c-1.5,0-2.717,1.217-2.717,2.717v1.857c0,5.627,5.32,10.214,11.936,10.392v0.71c0,1.5,1.217,2.717,2.717,2.717
                        c1.5,0,2.717-1.217,2.717-2.717v-0.71c6.616-0.179,11.936-4.765,11.936-10.392v-3.713c0-5.627-5.32-10.214-11.936-10.393v-13.665
                        c3.562,0.155,6.501,2.36,6.501,4.96v1.857C337.624,333.715,338.839,334.932,340.34,334.932z M319.185,334.072v-3.713
                        c0-2.6,2.939-4.806,6.501-4.96v13.634C322.124,338.877,319.185,336.672,319.185,334.072z M337.624,349.456v3.713
                        c0,2.6-2.939,4.805-6.501,4.96v-13.634C334.684,344.65,337.624,346.857,337.624,349.456z" />
                    </svg>
                    <div class="text-sm text-slate-700 font-semibold">
                      08.04.2022
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--Order section-->
          <div v-show="orderSection" class="md:w-[80%] shadow-lg rounded-xl border border-slate-50 p-6 md:p-8 text-slate-700">
            <h1 class="font-bold text-2xl mb-6 md:mb-8 text-center sm:text-left">
              Направи поръчка
            </h1>
            <div class="font-semibold mb-1 sm:mb-2 text-slate-500 text-sm md:text-base text-center sm:text-left">
              Вече може да нправите лесно поръчка и Вашият профил! Вече имаме
              част от вашите данни.
            </div>
            <?php
            $query = "SELECT * FROM customer WHERE email = '$email'";
            $query_run = mysqli_query($con, $query);

            while ($rows = mysqli_fetch_array($query_run)) {
            ?>
              <form id="customer-order-form">
                <div class="w-full mt-6 flex items-center gap-10 flex-wrap gap-y-4">
                  <div class="flex items-center">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span><?= $rows["name"] ?></span>
                    <input type="hidden" name="customerName" value="<?= $rows["name"] ?>">
                  </div>
                  <div class="flex items-center">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <span><?= $rows["email"] ?></span>
                    <input type="hidden" name="customerEmail" value="<?= $rows["email"] ?>">
                  </div>
                  <div class="flex items-center">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <span><?= $rows["phone"] ?></span>
                    <input type="hidden" name="customerPhone" value="<?= $rows["phone"] ?>">
                  </div>
                </div>
              <?php } ?>
              <hr class="w-full my-4" />

              <div class="block md:hidden ml-1 mb-1.5 font-semibold text-sm text-slate-700">
                Квадратура на обекта
              </div>
              <div class="block md:hidden mb-4">
                <input type="text" class="bg-slate-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:outline-none focus:border-gray-400 block w-full p-2.5 account-m2" placeholder="m2" />
              </div>

              <div class="block ml-1 mb-1.5 font-semibold text-sm md:text-base text-slate-700">
                Изберете вид помещение
              </div>
              <ul class="flex flex-wrap gap-6 my-3.5">
                <li>
                  <input class="sr-only peer building" type="radio" value="Къща" name="building" id="building-house" />
                  <label class="flex justify-center items-center w-28 h-28 bg-white border border-gray-200 rounded-md cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="building-house">
                    <div>
                      <div class="h-10 w-10 rounded-full flex justify-center items-center bg-blue-100 mx-auto border border-blue-200">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                      </div>
                      <div class="mt-1.5 text-sm font-semibold text-slate-700 text-center">
                        Къща
                      </div>
                    </div>
                  </label>
                </li>
                <li>
                  <input class="sr-only peer building" type="radio" value="Офис" name="building" id="building-office" />
                  <label class="flex justify-center items-center w-28 h-28 bg-white border border-gray-200 rounded-md cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="building-office">
                    <div>
                      <div class="h-10 w-10 rounded-full flex justify-center items-center bg-blue-100 mx-auto border border-blue-200">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                        </svg>
                      </div>
                      <div class="mt-1.5 text-sm font-semibold text-slate-700 text-center">
                        Офис
                      </div>
                    </div>
                  </label>
                </li>
                <li>
                  <input class="sr-only peer building" type="radio" value="Салон" name="building" id="building-hall" />
                  <label class="flex justify-center items-center w-28 h-28 bg-white border border-gray-200 rounded-md cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="building-hall">
                    <div>
                      <div class="h-10 w-10 rounded-full flex justify-center items-center bg-blue-100 mx-auto border border-blue-200">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                      </div>
                      <div class="mt-1.5 text-sm font-semibold text-slate-700 text-center">
                        Салон
                      </div>
                    </div>
                  </label>
                </li>
              </ul>

              <div class="block ml-1 mb-1.5 font-semibold text-sm md:text-base text-slate-700">
                Изберете вид оферта
              </div>
              <ul class="flex flex-wrap gap-6 my-3.5">
                <div id="tooltip-basic" role="tooltip" class="hidden md:inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-white text-slate-700 rounded-lg opacity-0 transition-opacity duration-300 tooltip shadow-xl border border-slate-100">
                  <div v-for="(service, index) in services" class="flex mt-1.5 items-center">
                    <svg v-show="index < 3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-green-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div v-show="index < 3">{{service}}</div>
                  </div>
                </div>
                <li data-tooltip-target="tooltip-basic" data-tooltip-placement="bottom">
                  <input class="sr-only peer offer" type="radio" value="Основна" name="offer" id="offer_basic" />
                  <label class="flex justify-center items-center w-28 h-28 bg-white border border-gray-200 rounded-md cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="offer_basic">
                    <div>
                      <div class="h-10 w-10 rounded-full flex justify-center items-center bg-blue-100 mx-auto border border-blue-200">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                      </div>
                      <div class="mt-1.5 text-sm font-semibold text-slate-700 text-center">
                        Основна
                      </div>
                    </div>
                  </label>
                </li>
                <div id="tooltip-premium" role="tooltip" class="hidden md:inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-white text-slate-700 rounded-lg opacity-0 transition-opacity duration-300 tooltip shadow-xl border border-slate-100">
                  <div v-for="(service, index) in services" class="flex mt-1.5 items-center">
                    <svg v-show="index < 5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-green-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div v-show="index < 5">{{service}}</div>
                  </div>
                </div>
                <li data-tooltip-target="tooltip-premium" data-tooltip-placement="bottom">
                  <input class="sr-only peer offer" type="radio" value="Премиум" name="offer" id="offer_premium" />
                  <label class="flex justify-center items-center w-28 h-28 bg-white border border-gray-200 rounded-md cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="offer_premium">
                    <div>
                      <div class="h-10 w-10 rounded-full flex justify-center items-center bg-blue-100 mx-auto border border-blue-200">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                        </svg>
                      </div>
                      <div class="mt-1.5 text-sm font-semibold text-slate-700 text-center">
                        Премиум
                      </div>
                    </div>
                  </label>
                </li>
                <div id="tooltip-vip" role="tooltip" class="hidden md:inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-white text-slate-700 rounded-lg opacity-0 transition-opacity duration-300 tooltip shadow-xl border border-slate-100">
                  <div v-for="service in services" class="flex mt-1.5 items-center">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-green-500">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>{{service}}</div>
                  </div>
                </div>
                <li data-tooltip-target="tooltip-vip" data-tooltip-placement="bottom">
                  <input class="sr-only peer offer" type="radio" value="Вип" name="offer" id="offer_vip" />
                  <label class="flex justify-center items-center w-28 h-28 bg-white border border-gray-200 rounded-md cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="offer_vip">
                    <div>
                      <div class="h-10 w-10 rounded-full flex justify-center items-center bg-blue-100 mx-auto border border-blue-200">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                      </div>
                      <div class="mt-1.5 text-sm font-semibold text-slate-700 text-center">
                        Вип
                      </div>
                    </div>
                  </label>
                </li>
              </ul>

              <div class="block ml-1 my-4 font-semibold text-sm md:text-base text-slate-700">
                Изберете дата и час
              </div>
              <div class="my-4 sm:flex items-center sm:space-x-5 space-y-4 sm:space-y-0">
                <div class="sm:w-1/2">
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                      </svg>
                    </div>
                    <input type="date" name="date" min="<?php echo date("Y-m-d", strtotime('+1 day', time())); ?>" value="<?php echo date("Y-m-d", strtotime('+1 day', time())); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-400 focus:outline-none block w-full pl-10 p-2.5 " placeholder="Изберете дата" />
                  </div>
                </div>
                <div class="w-1/2 flex space-x-5">
                  <div>
                    <input class="sr-only peer" type="radio" value="преди" name="time" id="time-before" />
                    <label class="flex justify-center items-center w-28 sm:w-32 md:w-28 lg:w-32 h-11 bg-white border border-gray-200 rounded-lg cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="time-before">
                      <div class="px-2 text-sm font-semibold text-slate-700 text-center">
                        Преди 13:00
                      </div>
                    </label>
                  </div>
                  <div>
                    <input class="sr-only peer" type="radio" value="след" name="time" id="time-after" />
                    <label class="flex justify-center items-center w-28 sm:w-32 md:w-28 lg:w-32 h-11 bg-white border border-gray-200 rounded-lg cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="time-after">
                      <div class="px-2 text-sm font-semibold text-slate-700 text-center">
                        След 13:00
                      </div>
                    </label>
                  </div>
                </div>
              </div>
              <div class="block ml-1 my-4 font-semibold text-sm md:text-base text-slate-700">
                Начин на плащане
              </div>
              <div class="flex flex-wrap items-center gap-3.5">
                <div>
                  <input class="sr-only peer" type="radio" value="В брой" name="payment" id="cash" />
                  <label class="flex justify-center items-center w-28 h-11 bg-white border border-gray-200 rounded-lg cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="cash">
                    <div class="flex items-center">
                      <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                      </svg>
                      <div class="text-sm font-semibold text-slate-700 text-center">
                        В брой
                      </div>
                    </div>
                  </label>
                </div>
                <div id="tooltip-card-payment" role="tooltip" class="hidden text-center font-medium text-slate-700 md:inline-block max-w-sm absolute invisible z-10 py-2 px-3 text-sm text-white bg-white text-slate-700 rounded-lg opacity-0 transition-opacity duration-300 tooltip shadow-xl border border-slate-100">
                  Не се притеснявайте ! Нашият екип ще носи POS терминал при посещението на имота Ви.
                </div>
                <div>
                  <input class="sr-only peer" type="radio" value="С карта" name="payment" id="card" />
                  <label data-tooltip-target="tooltip-card-payment" data-tooltip-placement="bottom" class="flex justify-center items-center w-28 h-11 bg-white border border-gray-200 rounded-lg cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" for="card">
                    <div class="flex items-center">
                      <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                      </svg>
                      <div class="text-sm font-semibold text-slate-700 text-center">
                        С карта
                      </div>
                    </div>
                  </label>
                </div>
              </div>
              <div class="block ml-1 my-4 font-semibold text-sm md:text-base text-slate-700">
                Изберете град
              </div>
              <div class="flex flex-wrap items-center gap-3.5">
                <div v-for="city in cities">
                  <input class="sr-only peer" type="radio" :value="city.name" name="city" :id="city.name" />
                  <label class="flex justify-center items-center w-28 h-11 bg-white border border-gray-200 rounded-lg cursor-pointer focus:outline-none hover:bg-blue-50 hover:border-blue-200 peer-checked:border-blue-200 peer-checked:bg-blue-50" :for="city.name">
                    <div class="text-sm font-semibold text-slate-700 text-center flex">
                      <div>
                        <img class="object-fill w-5 h-5 rounded-full mr-1" :src="city.image" :alt="city.name" />
                      </div>
                      <div>{{city.name}}</div>
                    </div>
                  </label>
                </div>
              </div>

              <label for="address" class="block ml-1 mb-1.5 mt-4 font-semibold text-sm md:text-base text-slate-700">
                Вашият адрес
              </label>
              <textarea @keyup="charCountAddress" minlength="5" id="address" name="address" v-model="address" rows="2" :class="{
                    'focus:border-red-500 border-red-500 bg-red-50': addressCount >= 200,
                  }" class="block p-2.5 w-full text-sm text-gray-900 bg-slate-50 rounded-lg border border-gray-300 focus:ring-0 focus:outline-none focus:border-gray-400 resize-none md:resize-y" placeholder="Напишете адреса си тук..."></textarea>
              <div :class="{
                    'text-red-500 font-semibold': addressCount >= 200,
                  }" class="w-full flex justify-end text-slate-600 text-sm -mb-1">
                {{ addressLength }}
              </div>

              <label for="information" class="block ml-1 mb-1.5 mt-4 font-semibold text-sm md:text-base text-slate-700">
                Допълнителна информация
              </label>
              <textarea @keyup="charCount" id="information" v-model="information" name="information" rows="2" :class="{
                    'focus:border-red-500 border-red-500 bg-red-50': informationCount >= 200,
                }" class="block p-2.5 w-full text-sm text-gray-900 bg-slate-50 rounded-lg border border-gray-300 focus:ring-0 focus:outline-none focus:border-gray-400 resize-none md:resize-y" placeholder="Пишете тук..."></textarea>
              <div :class="{
                    'text-red-500 font-semibold': informationCount >= 200,
                }" class="w-full flex justify-end text-slate-600 text-sm -mb-1">
                {{ informationLength }}
              </div>

              <!--Price toast-->
              <div v-show="orderSection" class="fixed md:flex bottom-4 right-4 items-center justify-center p-3 w-24 md:w-32 text-slate-700 bg-white rounded-md shadow-2xl border border-slate-100" :class="{'lg:right-4': scY < 300, 'lg:right-16': scY > 300}">
                <div id="account-toast-price" class="font-semibold text-sm md:text-base">
                  0 лв.
                </div>
                <input type="hidden" id="input-account-price" name="price" />
              </div>

              <div id="tooltip-m2" role="tooltip" class="hidden font-medium text-slate-700 md:inline-block max-w-sm absolute invisible z-10 py-2 px-3 text-sm text-white bg-white text-slate-700 rounded-lg opacity-0 transition-opacity duration-300 tooltip shadow-xl border border-slate-100">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -mt-1 mr-1 inline-flex">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Минимума е 10 квадратни метра.</span>
              </div>
              <!--M2 toast-->
              <div v-show="orderSection" data-tooltip-target="tooltip-m2" data-tooltip-placement="left" class="hidden md:block fixed md:flex bottom-20 right-4 items-center justify-center py-2 px-3 w-32 text-slate-700 bg-white rounded-md shadow-lg border border-slate-100" :class="{'lg:right-4': scY < 300, 'lg:right-16': scY > 300}">
                <div class="">
                  <label for="account-m2" class="block mb-1.5 text-sm font-semibold text-slate-700 text-center">
                    Квадратура
                  </label>
                  <input minlength="2" type="text" id="account-m2" name="m2" class="bg-slate-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-0 focus:outline-none focus:border-gray-300 block w-full p-1.5 text-center account-m2" maxlength="4" placeholder="m2" />
                </div>
              </div>

              <div class="sm:flex justify-start lg:justify-end mt-6">
                <button type="submit" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-0 font-semibold rounded-lg text-sm px-5 py-2.5 transition-all active:scale-90">
                  Направи поръчка
                </button>
              </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <script src="../js/main-vue.js"></script>
  <script src="../js/main.js"></script>
  <script src="../js/ajax.js"></script>
  <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
</body>

</html>