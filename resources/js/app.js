import './bootstrap';

import Alpine from 'alpinejs';
import { fixedCostChart } from './charts/fixedCostExpenseChart';
import { subScriptionChart } from './charts/subscriptionChart';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    if(document.getElementById('fixedCostChart')) {
        fixedCostChart();
    }

    if(document.getElementById('subScriptionChart')) {
        subScriptionChart();
    }
});
