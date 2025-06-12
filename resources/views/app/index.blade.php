<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <title>Aplus - grade book</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body class="vh-100 d-flex flex-column">
  <x-navbar :user="$user" :search="$search" />

  <div class="d-flex flex-grow-1 overflow-hidden">
    <x-sidebar />

    <div class="col-9 p-4 overflow-auto" id="content">
      {!! $ajaxView !!}
    </div>
  </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
  </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  $(document).on("click", ".content-link", function (e) {
    e.preventDefault();
    const url = $(this).data("url");
    console.log("Loading:", url);

    if (window.location.pathname !== url) {
      history.pushState({ url: url }, "", url);
    }

    loadContent(url);
  });

  function loadContent(url) {
    $.ajax({
      url: url,
      method: "GET",
      dataType: "html",
      beforeSend: function () {
        $("#content").html(`
        <div class="row h-100">
          <div class="mx-auto my-auto spinner-border" style="width: 7rem; height: 7rem;" role="status"></div>
        </div>`);
      },
      success: function (result) {
        $("#content").html(result);
      },
      error: function (error) {
        console.error("> View loading error: ", error);
        $("#content").html("<p class='text-danger'>Could not load view.</p>");
      }
    });
  }

  window.addEventListener("popstate", function (event) {
    if (event.state && event.state.url) {
      console.log("Go to:", event.state.url);
      loadContent(event.state.url);
    }
  });

  // // auto-loading func
  // $(document).ready(function () {
  //   const content = document.getElementById("content");
  //   const currentPath = window.location.pathname;

  //   const isContentEmpty =
  //     !content ||
  //     content.innerHTML.trim() === "" ||
  //     content.querySelector(".spinner-border");

  //   if (isContentEmpty && currentPath !== "/" && currentPath !== "/login") {
  //     console.log("Auto-loading current path after refresh:", currentPath);
  //     loadContent(currentPath);
  //   }
  // });
</script>

</html>