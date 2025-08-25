const next = document.querySelector(".next");
const prev = document.querySelector(".prev");
const Slides = document.querySelectorAll(".slide");
const Sliders = document.querySelectorAll(".slider");

let counter = 0;

next.addEventListener("click", function () {
    counter++;
    slide();
});

prev.addEventListener("click", function () {
    counter--;
    slide();
});

function slide() {
    let slidesToShow = 1; // Default for small screens
    let slideWidth = Slides[0].offsetWidth;

    if (window.matchMedia("(max-width: 1025px)").matches) {
        slidesToShow = 5; // Show 2 slides on medium screens
    }
    if (window.matchMedia("(min-width: 1100px)").matches) {
        slidesToShow = 5; // Show 5 slides on large screens
    }

    let totalSlides = Slides.length;
    let maxCounter = totalSlides - slidesToShow;

    if (counter > maxCounter) {
        counter = 0;
    }
    if (counter < 0) {
        counter = maxCounter;
    }

    Sliders.forEach(function (slider) {
        let slideContainerWidth = slider.offsetWidth;
        slideWidth = slideContainerWidth / slidesToShow; // Calculate correct slide width
        slider.style.transform = `translateX(-${counter * slideWidth}px)`;
    });
}

window.addEventListener("resize", slide); // Adjust slide on window resize


const next1 = document.querySelector(".next1");
const prev1 = document.querySelector(".prev1");
const Slides1 = document.querySelectorAll(".FeaturedSlide");
const Sliders1 = document.querySelectorAll(".FeaturedSlider");

let counter1 = 0;

next1.addEventListener("click", function () {
    counter1++;
    slide1();
    console.log(counter1);
});

prev1.addEventListener("click", function () {
    counter1--;
    slide1();
    console.log(counter1);
});

function slide1() {
    console.log("slideFunction");
    let slidesToShow1 = 1; // Default for small screens
    let slideWidth1 = Slides1[0].offsetWidth;

    console.log(slideWidth1);

    if (window.matchMedia("(max-width: 1025px)").matches) {
        slidesToShow1 = 2; // Show 2 slides on medium screens
    }
    if (window.matchMedia("(min-width: 1100px)").matches) {
        slidesToShow1 = 2; // Show 5 slides on large screens
    }
    if (window.matchMedia("(max-width: 426px)").matches) {
        slidesToShow1 = 2; // Show 5 slides on large screens
    }

    let totalSlides1 = Slides1.length;
    let maxCounter1 = totalSlides1 - slidesToShow1;

    if (counter1 > maxCounter1) {
        counter1 = 0;
    }
    if (counter1 < 0) {
        counter1 = maxCounter1;
    }

    Sliders1.forEach(function (slider1) {
        let slideContainerWidth1 = slider1.offsetWidth;
        slideWidth1 = slideContainerWidth1 / slidesToShow1; // Calculate correct slide width
        slider1.style.transform = `translateX(-${counter1 * slideWidth1}px)`;
    });
}

window.addEventListener("resize", slide1); // Adjust slide on window resize

const next2 = document.querySelector(".next2");
const prev2 = document.querySelector(".prev2");
const Slides2 = document.querySelectorAll(".FeaturedSlide2");
const Sliders2 = document.querySelectorAll(".FeaturedSlider2");

let counter2 = 0;

next2.addEventListener("click", function () {
    counter2++;
    slide2();
    console.log(counter2);
});

prev2.addEventListener("click", function () {
    counter2--;
    slide2();
    console.log(counter2);
});

function slide2() {
    console.log("slideFunction");
    let slidesToShow2 = 1; 
    let slideWidth2 = Slides2[0].offsetWidth;

    console.log(slideWidth2);

    
    if (window.matchMedia("(max-width: 1025px)").matches) {
        slidesToShow2 = 2; // Show 2 slides on medium screens
    }
    if (window.matchMedia("(min-width: 1100px)").matches) {
        slidesToShow2 = 2; // Show 5 slides on large screens
    }
    if (window.matchMedia("(max-width: 426px)").matches) {
        slidesToShow2 = 2; // Show 5 slides on large screens
    }

    let totalSlides2 = Slides2.length;
    console.log(totalSlides2);
    let maxCounter2 = totalSlides2 - slidesToShow2;
    console.log(maxCounter2);

    if (counter2 > maxCounter2) {
        counter2 = 0; 
    }
    if (counter2 < 0) {
        counter2 = maxCounter2; 
    }

    Sliders2.forEach(function (slider2) {
        let slideContainerWidth2 = slider2.offsetWidth;
        slideWidth2 = slideContainerWidth2 / slidesToShow2; 
        slider2.style.transform = `translateX(-${counter2 * slideWidth2}px)`;
    });
}


window.addEventListener("resize", slide2); 

    
function PaymentForBoost(event, postId, postName) {
    event.stopPropagation(); // Prevent the click event from bubbling up

    let paymentInfo = document.getElementById("PaymentInfo");
    paymentInfo.style.display = "flex";

    console.log(postId);
    console.log(postName);

    let postIdInput = document.getElementById('PostID');
    let postNameInput = document.getElementById('PostName1');

    if (postIdInput && postNameInput) {
        postIdInput.value = postId;
        postNameInput.value = postName.trim(); // Trim to remove any extra spaces
        console.log("PostID set to:", postIdInput.value);
        console.log("PostName set to:", postNameInput.value);
    } else {
        console.error("Input fields not found!");
    }

    function handleClickOutside(event) {
        if (!paymentInfo.contains(event.target)) {
            paymentInfo.style.display = "none";
            document.removeEventListener("click", handleClickOutside);
        }
    }

    document.addEventListener("click", handleClickOutside);
}



function PaymentMade(){
    let paymentInfo = document.getElementById("PaymentInfo");
    paymentInfo.style.display = "none";
    alert("Payment Successful!");
}

function BookTour(event, postId, postName) {
    event.stopPropagation();

    let paymentInfo = document.getElementById("BookTourInfo");
    paymentInfo.style.display = "flex";

    console.log(postId);
    console.log(postName);

    let postIdInput = document.getElementById('PostID');
    let postNameInput = document.getElementById('PostName1');

    if (postIdInput && postNameInput) {
        postIdInput.value = postId;
        postNameInput.value = postName.trim(); 
        console.log("PostID set to:", postIdInput.value);
        console.log("PostName set to:", postNameInput.value);
    } else {
        console.error("Input fields not found!");
    }

    function handleClickOutside(event) {
        if (!paymentInfo.contains(event.target)) {
            paymentInfo.style.display = "none";
            document.removeEventListener("click", handleClickOutside);
        }
    }

    document.addEventListener("click", handleClickOutside);
}

function BookTourMade(){
    let paymentInfo = document.getElementById("BookTourInfo");
    paymentInfo.style.display = "none";
    alert("Booked Tour Request Successfully!");
}