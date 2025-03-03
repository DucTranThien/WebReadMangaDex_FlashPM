document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".recommend-container");
    const mangaItems = document.querySelectorAll(".manga-container");
    const mangaWidth = mangaItems[0].offsetWidth;
    let leapCount = 0;
    let interval;
    //popup effect ( small window when user's mouse hover around )
    const mangaPopup = document.createElement("div");
    mangaPopup.classList.add("manga-popup");
    document.body.appendChild(mangaPopup);

    function slideManga() {
        container.style.transition = "transform 0.5s ease-in-out";
        container.style.transform = `translateX(-${mangaWidth}px)`;

        leapCount++;

        if (leapCount >= 2) {
            setTimeout(() => {
                container.style.transition = "none";
                const firstItem = container.firstElementChild;
                container.appendChild(firstItem);
                container.style.transform = "translateX(0)";
                leapCount = 0;
            }, 500);
        }
    }
    document.addEventListener("DOMContentLoaded", function () {
        const logo = document.querySelector(".logo");
    
        function changeGradient() {
            const colors = [
                "linear-gradient(45deg, red, orange, yellow)",
                "linear-gradient(45deg, blue, purple, pink)",
                "linear-gradient(45deg, green, cyan, blue)",
                "linear-gradient(45deg, violet, pink, red)"
            ];
            const randomIndex = Math.floor(Math.random() * colors.length);
            logo.style.background = colors[randomIndex];
            logo.style.webkitBackgroundClip = "text";
            logo.style.webkitTextFillColor = "transparent";
        }
    
        logo.addEventListener("mouseover", changeGradient);
    });
    

    function startSliding() {
        interval = setInterval(slideManga, 1500);
    }

    function stopSliding() {
        clearInterval(interval);
    }

    // Start auto-slide
    startSliding();

    // Pause sliding on hover & resume when mouse leaves
    container.addEventListener("mouseenter", stopSliding);
    container.addEventListener("mouseleave", startSliding);

    // 🎭 Show popup on hover
    mangaItems.forEach(item => {
        item.addEventListener("mouseenter", function (event) {
            const mangaTitle = this.querySelector(".title").innerText;
            const mangaStats = this.querySelector(".details").innerText;
            const mangaSummary = this.dataset.summary; 
            const mangaGif = this.dataset.gif; 

            mangaPopup.innerHTML = `
                <h3>${mangaTitle}</h3>
                <p class="stats">${mangaStats}</p>
                <p>${mangaSummary}</p>
            `;

            mangaPopup.style.backgroundImage = `url('${mangaGif}')`; // Set GIF background
            mangaPopup.style.display = "block";
            mangaPopup.style.left = `${event.pageX + 10}px`;
            mangaPopup.style.top = `${event.pageY + 10}px`;
        });

        item.addEventListener("mousemove", function (event) {
            mangaPopup.style.left = `${event.pageX + 10}px`;
            mangaPopup.style.top = `${event.pageY + 10}px`;
        });

        item.addEventListener("mouseleave", function () {
            mangaPopup.style.display = "none";
        });
    });
    
});
