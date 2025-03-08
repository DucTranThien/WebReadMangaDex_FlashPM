document.addEventListener("DOMContentLoaded", function () {
    // Recommendation Section Sliding
    const recommendContainer = document.querySelector(".recommend-container");
    const mangaItems = document.querySelectorAll(".manga-container");
    const mangaWidth = mangaItems[0]?.offsetWidth || 200;
    let leapCount = 0;
    let interval;

    // Popup effect
    const mangaPopup = document.createElement("div");
    mangaPopup.classList.add("manga-popup");
    document.body.appendChild(mangaPopup);

    // Sliding function for recommendation section only
    function slideManga() {
        recommendContainer.style.transition = "transform 0.5s ease-in-out";
        recommendContainer.style.transform = `translateX(-${mangaWidth}px)`;

        leapCount++;

        if (leapCount >= 2) {
            setTimeout(() => {
                recommendContainer.style.transition = "none";
                const firstItem = recommendContainer.firstElementChild;
                recommendContainer.appendChild(firstItem);
                recommendContainer.style.transform = "translateX(0)";
                leapCount = 0;
            }, 500);
        }
    }

    // Start and stop sliding for recommendation section only
    function startSliding() {
        interval = setInterval(slideManga, 1500);
    }

    function stopSliding() {
        clearInterval(interval);
    }

    if (recommendContainer) {
        startSliding();
        recommendContainer.addEventListener("mouseenter", stopSliding);
        recommendContainer.addEventListener("mouseleave", startSliding);
    }

    // Gradient change for logo
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

    if (logo) {
        logo.addEventListener("mouseover", changeGradient);
    }

    // Pagination for Latest Manga Section
    const latestContainer = document.querySelector("#latest-manga-container");
    const prevPageBtn = document.querySelector("#prev-page");
    const nextPageBtn = document.querySelector("#next-page");
    const currentPageSpan = document.querySelector("#current-page");
    let currentPage = parseInt(currentPageSpan.textContent);
    let mangaCache = []; // Store fetched manga for the current batch

    function loadManga(page) {
        fetch(`http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/api/get_latest_manga.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'success') {
                    latestContainer.innerHTML = `<p>Error: ${data.message}</p>`;
                    if (data.debug) {
                        latestContainer.innerHTML += `<pre>Debug Info: ${data.debug}</pre>`;
                    }
                    return;
                }

                // Update manga cache
                mangaCache[page] = data.data;

                // Render static containers with placeholders first
                latestContainer.innerHTML = '';
                data.data.forEach(manga => {
                    const mangaElement = document.createElement('div');
                    mangaElement.classList.add('manga-container', 'loading'); // Add loading class
                    mangaElement.setAttribute('data-summary', '');
                    mangaElement.setAttribute('data-gif', '');
                    mangaElement.innerHTML = `
                        <a href="manga_detail.php?mangadex_id=${manga.id}">
                            <img src="../assets/images/default.jpg" alt="${manga.name}" class="cover-placeholder">
                            <p class="title">${manga.name}</p>
                            <p class="details">📅 ${new Date(manga.newest_upload_date).toLocaleDateString('vi-VN')} | Chương ${manga.chapter}</p>
                        </a>
                    `;
                    latestContainer.appendChild(mangaElement);

                    // Fetch cover individually and update when ready
                    const coverUrlApi = `http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/api/get_cover.php?id=${encodeURIComponent(manga.id)}`;
                    fetch(coverUrlApi)
                        .then(res => res.json())
                        .then(coverData => {
                            if (coverData.status === 'success') {
                                mangaElement.querySelector('.cover-placeholder').src = coverData.data.cover_url;
                            }
                            mangaElement.classList.remove('loading'); // Remove loading state after cover is fetched
                        })
                        .catch(error => {
                            console.error(`Error loading cover for ${manga.id}:`, error);
                            mangaElement.classList.remove('loading'); // Remove loading even on error
                        });
                });

                // Update pagination controls
                currentPage = page;
                currentPageSpan.textContent = page;
                prevPageBtn.disabled = page === 1;

                // Pre-fetch next batch if needed (every 2 pages)
                const nextBatchPage = page + 2;
                if (!mangaCache[nextBatchPage]) {
                    fetch(`http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/api/get_latest_manga.php?page=${nextBatchPage}`)
                        .then(res => res.json())
                        .then(nextData => {
                            if (nextData.status === 'success') {
                                mangaCache[nextBatchPage] = nextData.data;
                            }
                        });
                }

                // Re-attach popup listeners to new manga containers
                attachPopupListeners();
            })
            .catch(error => {
                latestContainer.innerHTML = `<p>Error fetching manga: ${error.message}</p>`;
            });
    }

    function attachPopupListeners() {
        const mangaItems = document.querySelectorAll(".manga-container");
        mangaItems.forEach(item => {
            item.addEventListener("mouseenter", function (event) {
                const mangaTitle = this.querySelector(".title").innerText;
                const mangaStats = this.querySelector(".details").innerText;
                const mangaSummary = this.dataset.summary || "No summary available";
                const mangaGif = this.dataset.gif || "";

                mangaPopup.innerHTML = `
                    <h3>${mangaTitle}</h3>
                    <p class="stats">${mangaStats}</p>
                    <p>${mangaSummary}</p>
                `;

                mangaPopup.style.backgroundImage = `url('${mangaGif}')`;
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
    }

    // Initial load
    loadManga(currentPage);

    // Pagination button listeners
    nextPageBtn.addEventListener("click", () => {
        loadManga(currentPage + 1);
    });

    prevPageBtn.addEventListener("click", () => {
        if (currentPage > 1) {
            loadManga(currentPage - 1);
        }
    });
});