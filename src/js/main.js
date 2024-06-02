document.addEventListener('DOMContentLoaded', () => {
    const threadsContainer = document.getElementById('threads');
    threadsContainer.innerHTML = '<p>Loading threads...</p>';

    // Fetch threads from the server (we will implement this later)
    fetchThreads();

    function fetchThreads() {
        // Placeholder for fetching threads
        setTimeout(() => {
            threadsContainer.innerHTML = '<p>No threads found.</p>';
        }, 1000);
    }
});
