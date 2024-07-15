document.addEventListener('DOMContentLoaded', () => {
    const intro = introJs();

    // Get the current date and the first day of the current month
    const currentDate = new Date();
    const startOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const dateRangeText = `from ${startOfMonth.toLocaleDateString('en-US', options)} to ${currentDate.toLocaleDateString('en-US', options)}`;

    intro.setOptions({
        steps: [
            {
                element: '#dashboard-steps',
                intro: `
                    <h2>Welcome to the Dashboard!</h2>
                    <img src='/image/dashboard.svg' alt='Welcome Image' style='width: 100%;'>
                    <p>This is the dashboard overview.</p>
                    <button class='introjs-button introjs-nextpage-button' onclick='nextPage()'>Next Page</button>
                `,
                position: 'bottom'
            },
            {
                element: '#cardCountRcv',
                intro: `
                    <h2>Summary Receiving</h2>
                    <p>This section provides a summary of all received items ${dateRangeText}.</p>
                    <img src='/image/delivery.png' alt='Summary Receiving Image' style='max-width: 100%; height: auto;'>
                    <button class='introjs-button introjs-nextpage-button' onclick='nextPage()'>Next Page</button>
                `,
                position: 'bottom'
            },
            {
                element: '#cardCountPo',
                intro: `
                    <h2>Summary Purchase Order</h2>
                    <p>This section provides a summary of all purchase orders.</p>
                    <img src='/image/purchase_order.png' alt='Summary Purchase Order Image' style='max-width: 100%; height: 20%;'>
                    <button class='introjs-button introjs-nextpage-button' onclick='nextPage()'>Next Page</button>
                `,
                position: 'bottom'
            },
            {
                element: '#page2-step',
                intro: `
                    <h2>Page 2</h2>
                    <p>This is Page 2.</p>
                    <img src='https://example.com/image3.jpg' alt='Page 2 Image' style='max-width: 100%; height: auto;'>
                    <button class='introjs-button introjs-nextpage-button' onclick='nextPage()'>Next Page</button>
                `,
                position: 'bottom'
            }
        ]
    });

    // Function to handle next page navigation
    function nextPage() {
        // Replace with your actual next page URL
        window.location.href = '/items';
    }

    document.getElementById('start-tour').addEventListener('click', () => {
        intro.start();
    });
});
