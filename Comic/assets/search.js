document.getElementById("search-btn").addEventListener("click", function () {
    let query = document.getElementById("search-query").value;
    let status = document.getElementById("status").value;
    let sort = document.getElementById("sort").value;
    let categories = [];
    document.querySelectorAll("input[name='categories[]']:checked").forEach((checkbox) => {
        categories.push(checkbox.value);
    });

    let url = `search.php?query=${encodeURIComponent(query)}&status=${status}&sort=${sort}`;
    if (categories.length > 0) {
        url += `&categories=${categories.join(",")}`;
    }

    window.location.href = url;
});
