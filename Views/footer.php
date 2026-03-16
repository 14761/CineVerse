<?php

// If user is logged out show this footer
function renderLoggedOutFooter()
{
    echo '
    <div class="join-community">
        <h2>
            Join Our Community
        </h2>
        <p>Create your account to rate movies, leave comments, and build your personalized watchlist.</p>
        <a href="../Views/register.php" class="btn-primary">Register</a>
    </div>

    <div class="footer">
        <p>© 2026 CineVerse. All rights reserved.</p>
        <p>Your personal movie and TV show discovery platform</p>
    </div>
    ';
}

// If user is logged in show this footer
function renderLoggedInFooter()
{
    echo '
    <div class="footer">
        <p>© 2026 CineVerse. All rights reserved.</p>
        <p>Your personal movie and TV show discovery platform</p>
    </div>
    ';
}

