var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }

  if (myIndex > x.length - 1) {
    myIndex = 0;
  }
  x[myIndex].style.display = "block";
  myIndex++;
  setTimeout(carousel, 2000); // Change image every 2 seconds
}

document.getElementById("confirmMdp").addEventListener("keyup", function (e) {
  if (
    e.target.value.length >= 6 &&
    e.target.value === document.getElementById("mdp").value &&
    document.getElementById("mdp").value.length !== 0
  ) {
    document.getElementsByClassName("mdp-alert")[0].style.display = "none";
    document.getElementsByClassName("mdp-alert")[1].style.display = "block";
    document.getElementById("server-error").style.display = "none";
  } else if (
    e.target.value.length >= 6 &&
    document.getElementById("confirmMdp").value !==
      document.getElementById("mdp").value &&
    document.getElementById("mdp").value.length !== 0
  ) {
    document.getElementsByClassName("mdp-alert")[1].style.display = "none";
    document.getElementsByClassName("mdp-alert")[0].style.display = "block";
    document.getElementById("server-error").style.display = "none";
  }
});

document.getElementById("mdp").addEventListener("keyup", function (e) {
  if (
    e.target.value.length >= 6 &&
    document.getElementById("confirmMdp").value ===
      document.getElementById("mdp").value &&
    document.getElementById("confirmMdp").value.length !== 0
  ) {
    document.getElementsByClassName("mdp-alert")[0].style.display = "none";
    document.getElementsByClassName("mdp-alert")[1].style.display = "block";
    document.getElementById("server-error").style.display = "none";
  } else if (
    e.target.value.length >= 6 &&
    document.getElementById("confirmMdp").value !==
      document.getElementById("mdp").value &&
    document.getElementById("confirmMdp").value.length !== 0
  ) {
    document.getElementsByClassName("mdp-alert")[1].style.display = "none";
    document.getElementsByClassName("mdp-alert")[0].style.display = "block";
    document.getElementById("server-error").style.display = "none";
  } else if (
    document.getElementById("confirmMdp").value.length < 6 ||
    document.getElementById("mdp").value.length < 6
  ) {
    document.getElementsByClassName("mdp-alert")[1].style.display = "none";
    document.getElementsByClassName("mdp-alert")[0].style.display = "none";
    document.getElementById("server-error").style.display = "none";
  }
});

fetch("https://saurav.tech/NewsAPI/top-headlines/category/technology/fr.json")
  .then((res) => res.json())
  .then((res) => {
    for (let i = 0; i < res.articles.length; i++) {
      const clone = document
        .getElementsByClassName("ticker__item")[0]
        .cloneNode();
      clone.innerHTML = res.articles[i].title;

      document.getElementById("ticker").appendChild(clone);
    }
  });
