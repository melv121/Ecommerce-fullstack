document.addEventListener('DOMContentLoaded', () => {
    console.log("main.js loaded");

    initializeApp();


    document.addEventListener('click', async (e) => {
        if (e.target.matches('[data-link]')) {
            e.preventDefault();
            console.log(`Navigating to ${e.target.href}`);
            navigateTo(e.target.href);
        }
    });

    
    document.addEventListener('submit', async (e) => {
        if (e.target.matches('[data-form]')) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const url = new URL(e.target.action);
            url.search = new URLSearchParams(formData).toString();
            console.log(`Submitting form to ${url.toString()}`);
            navigateTo(url.toString());
        }
    });

    
    document.getElementById('main-content').addEventListener('click', function(event) {
        let target = event.target;
        if (target.classList.contains('pagination-link')) {
            event.preventDefault();
            const url = target.getAttribute('href');
            console.log(`Pagination link clicked: ${url}`);
            navigateTo(url);
        } else if (target.parentElement && target.parentElement.classList.contains('pagination-link')) {
            event.preventDefault();
            const url = target.parentElement.getAttribute('href');
            console.log(`Pagination link clicked: ${url}`);
            navigateTo(url);
        }
    });
});

async function navigateTo(url) {
    try {
        console.log(`Navigating to ${url}`);
       
        history.pushState(null, null, url);
        
        
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        
        const content = await response.text();
        document.getElementById('main-content').innerHTML = content;
        
        // Update page title if provided
        const titleMatch = content.match(/<title>(.*?)<\/title>/);
        if (titleMatch) {
            document.title = titleMatch[1];
        }
    } catch (error) {
        console.error('Navigation error:', error);
    }
}

function initializeApp() {
   
    window.addEventListener('popstate', () => {
        navigateTo(window.location.href);
    });

   
    navigateTo(window.location.href);
}
