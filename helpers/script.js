
// 
document.addEventListener("DOMContentLoaded", () => {
    const favouriteBtn = document.getElementById("favouriteBtn");

    if (!favouriteBtn) return;

    favouriteBtn.addEventListener("click", async () => {
        const movieId = favouriteBtn.dataset.movieId;

        try {
            const response = await fetch("../Controllers/UserController.php?action=toggleFavourite", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `movie_id=${encodeURIComponent(movieId)}`
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.message);
                return;
            }

            const icon = favouriteBtn.querySelector(".fav-icon");
            const text = favouriteBtn.querySelector(".fav-text");

            if (data.isFavourite) {
                favouriteBtn.classList.add("active");
                icon.textContent = "♥";
                text.textContent = "Remove from favourites";
            } else {
                favouriteBtn.classList.remove("active");
                icon.textContent = "♡";
                text.textContent = "Add to favourites";
            }

        } catch (error) {
            alert("Something went wrong. Please try again.");
        }
    });
});

