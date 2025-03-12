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
                    mangaElement.classList.add('manga-container', 'loading');
                    mangaElement.setAttribute('data-summary', manga.description || 'No summary available');
                    mangaElement.setAttribute('data-gif', '');
                    mangaElement.setAttribute('data-alt-titles', JSON.stringify(manga.altTitles || []));
                    mangaElement.setAttribute('data-status', manga.status || 'Unknown');
                    mangaElement.setAttribute('data-author-id', manga.authorId || '');

                    // Ensure the manga name is properly escaped for HTML attributes
                    const mangaName = manga.name ? manga.name.replace(/"/g, '&quot;') : 'Unknown Title';

                    // Use relative path with base tag
                    mangaElement.innerHTML = `
                        <a href="manga_detail.php?mangadex_id=${encodeURIComponent(manga.id)}">
                            <img src="../assets/images/default.jpg" alt="${mangaName}" class="cover-placeholder">
                            <p class="title">${mangaName}</p>
                            <p class="details">Loading ratings and follows...</p>
                            <div class="latest-chapters">Loading latest chapters...</div>
                        </a>
                    `;
                    latestContainer.appendChild(mangaElement);

                    // Fetch cover
                    const coverUrlApi = `http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/api/get_cover.php?id=${encodeURIComponent(manga.id)}`;
                    fetch(coverUrlApi)
                        .then(res => res.json())
                        .then(coverData => {
                            if (coverData.status === 'success') {
                                mangaElement.querySelector('.cover-placeholder').src = coverData.data.cover_url;
                            }
                            mangaElement.classList.remove('loading');
                        })
                        .catch(error => {
                            console.error(`Error loading cover for ${manga.id}:`, error);
                            mangaElement.classList.remove('loading');
                        });

                    // Fetch statistics (ratings and follows)
                    fetch(`https://api.mangadex.org/statistics/manga?manga[]=${manga.id}`)
                        .then(res => res.json())
                        .then(statsData => {
                            if (statsData.result === 'ok' && statsData.statistics && statsData.statistics[manga.id]) {
                                const stats = statsData.statistics[manga.id];
                                const rating = stats.rating && stats.rating.bayesian ? stats.rating.bayesian.toFixed(2) : 'N/A';
                                const follows = stats.follows || 0;
                                mangaElement.querySelector('.details').innerHTML = `⭐ ${rating} | 👥 ${follows}`;
                            } else {
                                mangaElement.querySelector('.details').innerHTML = `⭐ N/A | 👥 N/A`;
                            }
                        })
                        .catch(error => {
                            console.error(`Error loading statistics for ${manga.id}:`, error);
                            mangaElement.querySelector('.details').innerHTML = `⭐ N/A | 👥 N/A`;
                        });

                    // Fetch latest chapters (fetch 4, display 3)
                    fetch(`https://api.mangadex.org/manga/${manga.id}/feed?limit=4&order[chapter]=desc`)
                        .then(res => res.json())
                        .then(chapterData => {
                            console.log(`Chapters for ${manga.name} (${manga.id}):`, chapterData); // Debug log
                            if (chapterData.result === 'ok' && chapterData.data && chapterData.data.length > 0) {
                                const uniqueChapters = [];
                                const seenChapters = new Set();
                                chapterData.data.forEach(ch => {
                                    const chapterNumber = ch.attributes.chapter || `ch_${ch.id}`;
                                    if (!seenChapters.has(chapterNumber)) {
                                        seenChapters.add(chapterNumber);
                                        uniqueChapters.push(ch);
                                    }
                                });
                                const displayChapters = uniqueChapters.slice(0, 3);
                                const chapterLinks = displayChapters.map(ch => {
                                    const chapterNumber = ch.attributes.chapter || `Special ${ch.id.slice(0, 8)}`;
                                    const updatedAt = new Date(ch.attributes.updatedAt).toLocaleDateString('vi-VN');
                                    const chapterId = ch.id;
                                    return `<a href="readingpage.php?mangadex_id=${encodeURIComponent(manga.id)}&chapter=${encodeURIComponent(chapterNumber)}&chapter_id=${encodeURIComponent(chapterId)}" class="chapter-link">Ch. ${chapterNumber} (${updatedAt})</a>`;
                                }).join('<br>');
                                mangaElement.querySelector('.latest-chapters').innerHTML = displayChapters.length > 0 ? chapterLinks : 'No unique chapters available';
                            } else {
                                mangaElement.querySelector('.latest-chapters').innerHTML = 'No chapters available';
                            }
                        })
                        .catch(error => {
                            console.error(`Error loading chapters for ${manga.id}:`, error);
                            mangaElement.querySelector('.latest-chapters').innerHTML = 'Error loading chapters';
                        });

                    // Fetch author name if authorId exists
                    if (manga.authorId) {
                        fetch(`https://api.mangadex.org/author/${manga.authorId}`)
                            .then(res => res.json())
                            .then(authorData => {
                                if (authorData.result === 'ok') {
                                    mangaElement.setAttribute('data-author-name', authorData.data.attributes.name || 'Unknown');
                                } else {
                                    mangaElement.setAttribute('data-author-name', 'Unknown');
                                }
                            })
                            .catch(error => {
                                console.error(`Error loading author for ${manga.id}:`, error);
                                mangaElement.setAttribute('data-author-name', 'Unknown');
                            });
                    } else {
                        mangaElement.setAttribute('data-author-name', 'Unknown');
                    }
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
        const mangaItems = latestContainer.querySelectorAll(".manga-container");
        mangaItems.forEach(item => {
            item.addEventListener("mouseenter", function (event) {
                const mangaTitle = this.querySelector(".title").innerText;
                const mangaStats = this.querySelector(".details").innerText;
                const mangaSummary = this.dataset.summary || "No summary available";
                const mangaGif = this.dataset.gif || "";
                const altTitles = JSON.parse(this.dataset.altTitles || "[]");
                const status = this.dataset.status || "Unknown";
                const authorName = this.dataset.authorName || "Unknown";

                const altTitlesText = altTitles.length > 0
                    ? altTitles.map(title => title.ja || Object.values(title)[0]).join(', ')
                    : "None";

                mangaPopup.innerHTML = `
                    <h3>${mangaTitle}</h3>
                    <p><strong>Stats:</strong> ${mangaStats}</p>
                    <p><strong>Alternative Titles:</strong> ${altTitlesText}</p>
                    <p><strong>Description:</strong> ${mangaSummary}</p>
                    <p><strong>Author:</strong> ${authorName}</p>
                    <p><strong>Status:</strong> ${status}</p>
                `;

                mangaPopup.style.backgroundImage = `url('${mangaGif}')`;
                mangaPopup.style.display = "block";
                mangaPopup.style.left = `${event.pageX + 10}px`;
                mangaPopup.style.top = `${event.pageY + 10}px`;

                const popupRect = mangaPopup.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;
                if (popupRect.right > viewportWidth) {
                    mangaPopup.style.left = `${event.pageX - popupRect.width - 10}px`;
                }
                if (popupRect.bottom > viewportHeight) {
                    mangaPopup.style.top = `${event.pageY - popupRect.height - 10}px`;
                }
            });

            item.addEventListener("mousemove", function (event) {
                mangaPopup.style.left = `${event.pageX + 10}px`;
                mangaPopup.style.top = `${event.pageY + 10}px`;

                const popupRect = mangaPopup.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;
                if (popupRect.right > viewportWidth) {
                    mangaPopup.style.left = `${event.pageX - popupRect.width - 10}px`;
                }
                if (popupRect.bottom > viewportHeight) {
                    mangaPopup.style.top = `${event.pageY - popupRect.height - 10}px`;
                }
            });

            item.addEventListener("mouseleave", function () {
                mangaPopup.style.display = "none";
            });
        });
    }

    loadManga(currentPage);

    nextPageBtn.addEventListener("click", () => {
        loadManga(currentPage + 1);
    });

    prevPageBtn.addEventListener("click", () => {
        if (currentPage > 1) {
            loadManga(currentPage - 1);
        }
    });
});