<?php
require_once __DIR__ . '/../Models/DBManager.php';

function renderCommentsSection(int $id): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Gets the reviews for the movie
    $dbManager = DBManager::get_instance();
    $reviews = $dbManager->get_reviews_by_movie($id);

    // Checks if the user is logged in
    $isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    ?>

    <?php if ($isLoggedIn): ?>
        <form action="../Controllers/MovieController.php?action=rate_movie&movie_id=<?php echo $id; ?>" method="POST">
            <div class="comments-container">
                <div class="mb-3">
                    <label class="form-label text-light">Your Rating</label>

                    <div class="star-rating">
                        <?php for ($i = 10; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>">
                            <label for="star<?php echo $i; ?>">★</label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="comments-container2">
                    <textarea name="comment" placeholder="Share your thoughts."></textarea>
                </div>

                <div id="ratingMessage"></div>
                <button type="submit" class="btn btn-primary btn-post">Post</button>
            </div>
        </form>

        <div class="reviews-list mt-4">
            <span>User comments</span>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item mb-3 p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-light">
                                <?php echo htmlspecialchars($review['username']); ?>
                            </strong>
                            <span class="text-warning">
                                <?php echo htmlspecialchars((string) $review['rating']); ?>/10
                            </span>
                        </div>

                        <p class="text-light mt-2 mb-0">
                            <?php echo nl2br(htmlspecialchars($review['comment'])); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted mt-3">No reviews yet. Be the first!</p>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <div class="comments-container">
            <div class="comments-overlay">
                <p>Please log in to write a comment</p>
            </div>
            <div class="stars">
                <textarea placeholder="Share your thoughts." disabled></textarea>
                <button class="btn btn-primary btn-post" disabled>Post</button>
            </div>
        </div>

        <div class="reviews-list mt-4">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item mb-3 p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-light">
                                <?php echo htmlspecialchars($review['username']); ?>
                            </strong>
                            <span class="text-warning">
                                <?php echo htmlspecialchars((string) $review['rating']); ?>/10
                            </span>
                        </div>

                        <p class="text-light mt-2 mb-0">
                            <?php echo nl2br(htmlspecialchars($review['comment'])); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted mt-3">No reviews yet. Be the first!</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php
}
?>