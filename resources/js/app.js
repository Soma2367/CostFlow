import './bootstrap';

import Alpine from 'alpinejs';
import { fixedCostChart } from './charts/fixedCostExpenseChart';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    fixedCostChart();
});
