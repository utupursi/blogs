import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
// $(document).ready(function () {
//     $('#news_form_category').select2();
// });

document.addEventListener('turbo:load', function () {
    $('#news_form_category').select2();
});
