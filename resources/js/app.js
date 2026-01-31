import './bootstrap';

import Alpine from 'alpinejs';
import { adminChart } from './charts/adminChart';
import { fixedCostChart } from './charts/fixedCostExpenseChart';
import { subScriptionChart } from './charts/subscriptionChart';


window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    if(document.getElementById('adminChart')) {
        adminChart();
    }

    if(document.getElementById('fixedCostChart')) {
        fixedCostChart();
    }

    if(document.getElementById('subScriptionChart')) {
        subScriptionChart();
    }
});
