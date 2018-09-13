import Chart from 'chart.js';
import Vue from 'vue';
import axios from 'axios';
import 'chartjs-plugin-datalabels';

var graficoCapsulesTotal;
var graficoCapsulesPlatinum;
var graficoCapsulesGold;
var graficoClaimsTotal;
var graficoClaimsPlatinum;
var graficoClaimsGold;
var graficoMachinesTotal;
var graficoMachinesPlatinum;
var graficoMachinesGold;

new Vue({
  el: '#app',
  data: {
    tab: 'first',
    filtertab: 'total',
    filtertabCapsules: 'total',
    filtertabClaims: 'total',
    filtertabMachines: 'total',
    start_date: {
      month: {month:'Ene',value:1},
      year: 2017
    },
    end_date: {
      month: {month:'Jun',value:6},
      year: 2018
    },
    capsules: {
      quantityByMonth: '0',
      platinum: {
        quantityTotalByUser: '0',
        averageByUser: '0'
      },
      gold: {
        quantityTotalByUser: '0',
        averageByUser: '0'
      }
    },
    claims: {
      quantityByMonth: '0',
      platinum: {
        quantityTotalByUser: '0',
        averageByUser: '0',
        acquisitionAverage: '0'
      },
      gold: {
        quantityTotalByUser: '0',
        averageByUser: '0',
        acquisitionAverage: '0'
      }
    },
    machines: {
      quantityByMonth: '0',
      platinum: {
        totalMachinesByUser: '0',
        quantityAverageByUser: '0',
        bestMonth: {month: '', year: ''},
        frecuencieaverage: ''
      },
      gold: {
        totalMachinesByUser: '0',
        quantityAverageByUser: '0',
        bestMonth: {month: '', year: ''},
        frecuencieaverage: '0'
      }
    },
    configBarChartCapsulesTotal: {
      labels: [],
      valuesGold: [],
      valuesPlatinum: [],
      datasets: []
    },
    configLineChartCapsulesPlatinum: {
      labels: [],
      valuesGold: [],
      averageGold: [],
      valuesPlatinum: [],
      averagePlatinum:[],
      datasets: []
    },
    configLineChartCapsulesGold: {
      labels: [],
      valuesGold: [],
      averageGold: [],
      valuesPlatinum: [],
      averagePlatinum:[],
      datasets: []
    },
    configBarChartClaimsTotal: {
      labels: [],
      valuesGold: [],
      valuesPlatinum: [],
      datasets: []
    },
    configLineChartClaimsPlatinum: {
      labels: [],
      valuesGold: [],
      averageGold: [],
      valuesPlatinum: [],
      averagePlatinum:[],
      datasets: []
    },
    configLineChartClaimsGold: {
      labels: [],
      valuesGold: [],
      averageGold: [],
      valuesPlatinum: [],
      averagePlatinum:[],
      datasets: []
    },
    configBarChartMachineTotal: {
      labels: [],
      valuesGold: [],
      valuesPlatinum: [],
      datasets: []
    },
    configLineChartMachinesPlatinum: {
      labels: [],
      valuesGold: [],
      averageGold: [],
      valuesPlatinum: [],
      averagePlatinum:[],
      datasets: []
    },
    configLineChartMachinesGold: {
      labels: [],
      valuesGold: [],
      averageGold: [],
      valuesPlatinum: [],
      averagePlatinum:[],
      datasets: []
    },
    showCalendarStart: false,
    showCalendarEnd: false,
    months: [
      {month:'Ene', nameMonth: 'Enero', value:1},
      {month:'Feb', nameMonth: 'Febrero', value:2},
      {month:'Mar', nameMonth: 'Marzo', value:3},
      {month:'Abr', nameMonth: 'Abril', value:4},
      {month:'May', nameMonth: 'Mayo', value:5},
      {month:'Jun', nameMonth: 'Junio', value:6},
      {month:'Jul', nameMonth: 'Julio', value:7},
      {month:'Ago', nameMonth: 'Agosto', value:8},
      {month:'Set', nameMonth: 'Setiembre', value:9},
      {month:'Oct', nameMonth: 'Octubre', value:10},
      {month:'Nov', nameMonth: 'Noviembre', value:11},
      {month:'Dic', nameMonth: 'Diciembre', value:12}
    ],
  },
  mounted() {
    this.getDataCapsulesTotal();
  },
  methods: {
    getDataCapsulesTotal() {
      const url = '/reports/capsules/capsules-quantity-by-month';
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        this.renderChartCapsulesTotal(response.data);
      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    getDataCapsulesPlatinum(url, order) {
      // const url = '/reports/capsules/capsules-quantity-by-month';
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        if( order === 1) { // primera url
          this.renderChartCapsulesPlatinum(response.data);
        } else if( order === 2)  { // segunda url
          this.capsules.platinum.averageByUser = response.data.platinum;
          this.capsules.gold.averageByUser = response.data.gold;
        } else { // tercera url
          this.capsules.platinum.quantityTotalByUser = response.data.platinum;
          this.capsules.gold.quantityTotalByUser = response.data.gold;
        }
      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    getDataCapsulesGold(url, order) {
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        if( order === 1) {
          this.renderChartCapsulesGold(response.data);
        } else if( order === 2)  {
          this.capsules.platinum.averageByUser = response.data.platinum;
          this.capsules.gold.averageByUser = response.data.gold;
        } else {
          this.capsules.platinum.quantityTotalByUser = response.data.platinum;
          this.capsules.gold.quantityTotalByUser = response.data.gold;
        }
      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    getDataClaimsTotal() {
      const url = '/reports/claims/claims-quantity-by-month';
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        this.renderChartClaimsTotal(response.data);
      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    getDataClaimsPlatinum(url, order) {
      // let url = '/reports/claims/claims-quantity-by-month';
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        if( order === 1) { // primera url
          this.renderChartClaimsPlatinum(response.data);
        } else if( order === 2)  { // segunda url
          this.claims.platinum.quantityTotalByUser = response.data.platinum;
          this.claims.gold.quantityTotalByUser = response.data.gold;
        } else if(order === 3) { // tercera url
          this.claims.platinum.averageByUser = response.data.platinum;
          this.claims.gold.averageByUser = response.data.gold;
        } else {
          this.claims.platinum.acquisitionAverage = response.data.platinum;
          this.claims.gold.acquisitionAverage = response.data.gold;
        };
      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    getDataClaimsGold(url, order) {
      // let url = '/reports/claims/claims-quantity-by-month';
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        if( order === 1) { // primera url
          this.renderChartClaimsGold(response.data);
        } else if( order === 2)  { // segunda url
          this.claims.platinum.quantityTotalByUser = response.data.platinum;
          this.claims.gold.quantityTotalByUser = response.data.gold;
        } else if(order === 3) { // tercera url
          this.claims.platinum.averageByUser = response.data.platinum;
          this.claims.gold.averageByUser = response.data.gold;
        } else {
          this.claims.platinum.acquisitionAverage = response.data.platinum;
          this.claims.gold.acquisitionAverage = response.data.gold;
        };
      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    getDataMachinesTotal() {
      const url = '/reports/machines/machines-quantity-by-month';
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        this.renderChartMachinesTotal(response.data);

      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    getDataMachinesPlatinum(url, order) {
      // const url = '/reports/machines/machines-quantity-by-month';
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        if( order === 1) { // primera url
          this.renderChartMachinesPlatinum(response.data);
        } else if( order === 2)  { // segunda url
          this.machines.platinum.quantityAverageByUser = response.data.platinum;
          this.machines.gold.quantityAverageByUser = response.data.gold;
        } else if(order === 3) { // tercera url
          this.machines.platinum.bestMonth.month = this.setNameMonth(response.data.month);
          this.machines.platinum.bestMonth.year = response.data.year;
          this.machines.gold.bestMonth.month = this.setNameMonth(response.data.month);
          this.machines.gold.bestMonth.year = response.data.year;
        } else {
          this.machines.platinum.frecuencieaverage = response.data.platinum;
          this.machines.gold.frecuencieaverage = response.data.gold;
        };
      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    getDataMachinesGold(url, order) {
      // const url = '/reports/machines/machines-quantity-by-month';
      axios.get(url, {
        params: {
          start_month: this.start_date.month.value,
          start_year: this.start_date.year,
          end_month: this.end_date.month.value,
          end_year: this.end_date.year
        }
      })
      .then(response => {
        if( order === 1) { // primera url
          this.renderChartMachinesGold(response.data);
        } else if( order === 2)  { // segunda url
          this.machines.platinum.quantityAverageByUser = response.data.platinum;
          this.machines.gold.quantityAverageByUser = response.data.gold;
        } else if(order === 3) { // tercera url
          this.machines.platinum.bestMonth.month = this.setNameMonth(response.data.month);
          this.machines.platinum.bestMonth.year = response.data.year;
          this.machines.gold.bestMonth.month = this.setNameMonth(response.data.month);
          this.machines.gold.bestMonth.year = response.data.year;
        } else {
          this.machines.platinum.frecuencieaverage = response.data.platinum;
          this.machines.gold.frecuencieaverage = response.data.gold;
        };

      })
      .catch(error => {
        if(error.response.status == "401"){
          window.top.location = '/';
        }
      })
      .then(function () {
        // always executed
      });
    },
    urlDataCapsulesPlatinum() {
      // url apis
      this.getDataCapsulesPlatinum('/reports/capsules/capsules-quantity-by-month', 1);
      this.getDataCapsulesPlatinum('/reports/capsules/capsules-average-by-user', 2);
      this.getDataCapsulesPlatinum('/reports/capsules/capsules-total', 3);
    },
    urlDataCapsulesGold() {
      // url apis
      this.getDataCapsulesGold('/reports/capsules/capsules-quantity-by-month', 1);
      this.getDataCapsulesGold('/reports/capsules/capsules-average-by-user', 2);
      this.getDataCapsulesGold('/reports/capsules/capsules-total', 3);
    },
    urlDataClaimsPlatinum() {
      // url apis
      this.getDataClaimsPlatinum('/reports/claims/claims-quantity-by-month', 1);
      this.getDataClaimsPlatinum('/reports/claims/claims-total', 2);
      this.getDataClaimsPlatinum('/reports/claims/claims-average-by-user', 3);
      this.getDataClaimsPlatinum('/reports/claims/claims-acquisition-average-by-user', 4);
    },
    urlDataClaimsGold() {
      // url apis
      this.getDataClaimsGold('/reports/claims/claims-quantity-by-month', 1);
      this.getDataClaimsGold('/reports/claims/claims-total', 2);
      this.getDataClaimsGold('/reports/claims/claims-average-by-user', 3);
      this.getDataClaimsGold('/reports/claims/claims-acquisition-average-by-user', 4);
    },
    urlDataMachinesPlatinum() {
      // url apis
      // this.getDataMachinesTotal('/reports/machines/machines-total', 1)
      this.getDataMachinesPlatinum('/reports/machines/machines-quantity-by-month', 1);
      this.getDataMachinesPlatinum('/reports/machines/machines-average-by-user', 2);
      this.getDataMachinesPlatinum('/reports/machines/machines-best-month', 3);
      this.getDataMachinesPlatinum('/reports/machines/machines-acquisition-average-by-user', 4);
    },
    urlDataMachinesGold() {
      // url apis
      // this.getDataMachinesTotal('/reports/machines/machines-total', 1)
      this.getDataMachinesGold('/reports/machines/machines-quantity-by-month', 1);
      this.getDataMachinesGold('/reports/machines/machines-average-by-user', 2);
      this.getDataMachinesGold('/reports/machines/machines-best-month', 3);
      this.getDataMachinesGold('/reports/machines/machines-acquisition-average-by-user', 4);
    },
    renderChartCapsulesTotal(data) {
      // me vas a sacar canas verdes
      this.configBarChartCapsulesTotal = {
        labels: [],
        valuesGold: [],
        valuesPlatinum: [],
        datasets: []
      };



      // obtiene la data para graficar
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configBarChartCapsulesTotal.labels.push(month + ' ' + data[i].year);
        this.configBarChartCapsulesTotal.valuesGold.push(data[i].total.gold);
        this.configBarChartCapsulesTotal.valuesPlatinum.push(data[i].total.platinum);
      };
      this.configBarChartCapsulesTotal.datasets.push({
        backgroundColor: '#a08066',
        label: 'Oro',
        data: this.configBarChartCapsulesTotal.valuesGold
      });
      this.configBarChartCapsulesTotal.datasets.push({
        backgroundColor: '#766357',
        label: 'Platino',
        data: this.configBarChartCapsulesTotal.valuesPlatinum
      });
      // pasa valores para graficar
      let datos = {
        labels : this.configBarChartCapsulesTotal.labels,
        datasets : this.configBarChartCapsulesTotal.datasets
      };

      console.log(Chart.defaults);
      // Chart.defaults.global.tooltips.enabled = false;
      // Chart.defaults.global.plugins.datalabels.anchor = 'center';
      // Chart.defaults.global.plugins.datalabels.padding.top = -13;
      // Chart.defaults.global.plugins.datalabels.padding.bottom = 0;
      // Chart.defaults.global.plugins.datalabels.align = 'start';
      // Chart.defaults.global.plugins.datalabels.color = function(context) {
      //   let chart = context.chart;
      //   let area = context.chart.chartArea;
      //   let model = context.chart.getDatasetMeta(context.datasetIndex).data[context.dataIndex]._model;
      //   let height = model.x - area.right;
      //   console.log(model.x);
      //   return height < 0 ? '#ffffff' : '#000000'
      // };

      Chart.defaults.global.tooltips.enabled = false;
      Chart.defaults.global.plugins.datalabels.anchor = 'center';
      Chart.defaults.bar.plugins.datalabels.anchor = 'center';
      Chart.defaults.global.plugins.datalabels.padding.top = -13;
      Chart.defaults.global.plugins.datalabels.padding.bottom = 0;
      Chart.defaults.global.plugins.datalabels.align = 'start';
      Chart.defaults.global.plugins.datalabels.color = function(context) {
        let chart = context.chart;
        let area = context.chart.chartArea;
        let model = context.chart.getDatasetMeta(context.datasetIndex).data[context.dataIndex]._model;
        let height = model.x - area.right;
        console.log(model.x);
        return height < 0 ? '#ffffff' : '#000000'
      };

      let barchart = document.getElementById('barChartCapsulas');
      if(graficoCapsulesTotal) graficoCapsulesTotal.destroy();

      graficoCapsulesTotal = new Chart(barchart, {
        type : "bar",
        data : datos,
        options: {
          scales: {
            yAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true
              }
            }],
            xAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true
              }
            }]
          },
          legend: {
            display: false,
            onClick: (e) => e.stopPropagation()
          },
          plugins: { datalabels: { formatter: function(value) { return value } } },
        }
      });

    },
    renderChartCapsulesPlatinum(data) {
      this.configLineChartCapsulesPlatinum = {
        labels: [],
        valuesGold: [],
        averageGold: [],
        valuesPlatinum: [],
        averagePlatinum:[],
        datasets: []
      };
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configLineChartCapsulesPlatinum.labels.push(month + ' ' + data[i].year);
        this.configLineChartCapsulesPlatinum.valuesPlatinum.push(data[i].total.platinum);
        this.configLineChartCapsulesPlatinum.averagePlatinum.push(data[i].average.platinum);
      };
      this.configLineChartCapsulesPlatinum.datasets.push({
        borderColor: '#af006a',
        fill: false,
        label: 'Total de unidades',
        data: this.configLineChartCapsulesPlatinum.valuesPlatinum
      });
      this.configLineChartCapsulesPlatinum.datasets.push({
        borderColor: '#009cde',
        fill: false,
        label: 'Promedio de unidades',
        data: this.configLineChartCapsulesPlatinum.averagePlatinum
      });
      // Pasa valores para graficar
      let datos = {
        labels : this.configLineChartCapsulesPlatinum.labels,
        datasets : this.configLineChartCapsulesPlatinum.datasets
      };

      let lineChart = document.getElementById('lineChartCapsulasPlatino');
      if(graficoCapsulesPlatinum) graficoCapsulesPlatinum.destroy();

      graficoCapsulesPlatinum = new Chart(lineChart, {
        type : "line",
        data : datos,
        options: {
          legend: {
            position: 'bottom',
            onClick: (e) => e.stopPropagation()
          }
        }
      });
      datos = {
        labels : '',
        datasets : ''
      };
    },
    renderChartCapsulesGold(data) {
      this.configLineChartCapsulesGold = {
        labels: [],
        valuesGold: [],
        averageGold: [],
        valuesPlatinum: [],
        averagePlatinum:[],
        datasets: []
      };
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configLineChartCapsulesGold.labels.push(month + ' ' + data[i].year);
        this.configLineChartCapsulesGold.valuesGold.push(data[i].total.gold);
        this.configLineChartCapsulesGold.averageGold.push(data[i].average.gold);
      };
      this.configLineChartCapsulesGold.datasets.push({
        borderColor: '#af006a',
        fill: false,
        label: 'Total de unidades',
        data: this.configLineChartCapsulesGold.valuesGold
      });
      this.configLineChartCapsulesGold.datasets.push({
        borderColor: '#009cde',
        fill: false,
        label: 'Promedio de unidades',
        data: this.configLineChartCapsulesGold.averageGold
      });
      // pasa datos para graficar
      let datos = {
        labels : this.configLineChartCapsulesGold.labels,
        datasets : this.configLineChartCapsulesGold.datasets
      };

      let lineChart = document.getElementById('lineChartCapsulasGold');
      if(graficoCapsulesGold) graficoCapsulesGold.destroy();

      graficoCapsulesGold = new Chart(lineChart, {
        type : "line",
        data : datos,
        options: {
          legend: {
            position: 'bottom',
            onClick: (e) => e.stopPropagation()
          }
        }
      });
      datos = {
        labels : '',
        datasets : ''
      };
    },
    renderChartClaimsTotal(data) {
      this.configBarChartClaimsTotal = {
        labels: [],
        valuesGold: [],
        valuesPlatinum: [],
        datasets: []
      };
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configBarChartClaimsTotal.labels.push(month + ' ' + data[i].year);
        this.configBarChartClaimsTotal.valuesGold.push(data[i].total.gold);
        this.configBarChartClaimsTotal.valuesPlatinum.push(data[i].total.platinum);
      };
      this.configBarChartClaimsTotal.datasets.push({
        backgroundColor: '#a08066',
        label: 'Oro',
        data: this.configBarChartClaimsTotal.valuesGold
      });
      this.configBarChartClaimsTotal.datasets.push({
        backgroundColor: '#766357',
        label: 'Platino',
        data: this.configBarChartClaimsTotal.valuesPlatinum
      });
      // pasa valores para graficar
      let datos = {
        labels : this.configBarChartClaimsTotal.labels,
        datasets : this.configBarChartClaimsTotal.datasets
      };
      let barchart = document.getElementById('barChartCanjes');
      if(graficoClaimsTotal) graficoClaimsTotal.destroy();

      graficoClaimsTotal = new Chart(barchart, {
        type : "bar",
        data : datos,
        options: {
          scales: {
            yAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true
              }
            }],
            xAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true
              }
            }]
          },
          legend: {
            position: 'bottom',
            onClick: (e) => e.stopPropagation()
          }
        }
      });
    },
    renderChartClaimsPlatinum(data) {
      this.configLineChartClaimsPlatinum = {
        labels: [],
        valuesGold: [],
        averageGold: [],
        valuesPlatinum: [],
        averagePlatinum:[],
        datasets: []
      };
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configLineChartClaimsPlatinum.labels.push(month + ' ' + data[i].year);
        this.configLineChartClaimsPlatinum.valuesPlatinum.push(data[i].total.platinum);
        this.configLineChartClaimsPlatinum.averagePlatinum.push(data[i].average.platinum);
      };
      this.configLineChartClaimsPlatinum.datasets.push({
        borderColor: '#af006a',
        fill: false,
        label: 'Total de unidades',
        data: this.configLineChartClaimsPlatinum.valuesPlatinum
      });
      this.configLineChartClaimsPlatinum.datasets.push({
        borderColor: '#009cde',
        fill: false,
        label: 'Promedio de unidades',
        data: this.configLineChartClaimsPlatinum.averagePlatinum
      });
      // pasa datos para graficar
      let datos = {
        labels : this.configLineChartClaimsPlatinum.labels,
        datasets : this.configLineChartClaimsPlatinum.datasets
      };

      let lineChart = document.getElementById('lineChartCanjesPlatino');
      if(graficoClaimsPlatinum) graficoClaimsPlatinum.destroy();

      graficoClaimsPlatinum = new Chart(lineChart, {
        type : "line",
        data : datos,
        options: {
          legend: {
            position: 'bottom',
            onClick: (e) => e.stopPropagation()
          }
        }
      });
    },
    renderChartClaimsGold(data) {
      this.configLineChartClaimsGold = {
        labels: [],
        valuesGold: [],
        averageGold: [],
        valuesPlatinum: [],
        averagePlatinum:[],
        datasets: []
      };
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configLineChartClaimsGold.labels.push(month + ' ' + data[i].year);
        this.configLineChartClaimsGold.valuesGold.push(data[i].total.gold);
        this.configLineChartClaimsGold.averageGold.push(data[i].average.gold);
      };
      this.configLineChartClaimsGold.datasets.push({
        borderColor: '#af006a',
        fill: false,
        label: 'Total de unidades',
        data: this.configLineChartClaimsGold.valuesGold
      });
      this.configLineChartClaimsGold.datasets.push({
        borderColor: '#009cde',
        fill: false,
        label: 'Promedio de unidades',
        data: this.configLineChartClaimsGold.averageGold
      });
      // pasa datos para graficar
      let datos = {
        labels : this.configLineChartClaimsGold.labels,
        datasets : this.configLineChartClaimsGold.datasets
      };

      let lineChart = document.getElementById('lineChartCanjesGold');
      if(graficoClaimsGold) graficoClaimsGold.destroy();

      graficoClaimsGold = new Chart(lineChart, {
        type : "line",
        data : datos,
        options: {
          legend: {
            position: 'bottom',
            onClick: (e) => e.stopPropagation()
          }
        }
      });
    },
    renderChartMachinesTotal(data) {
      this.configBarChartMachineTotal = {
        labels: [],
        valuesGold: [],
        valuesPlatinum: [],
        datasets: []
      };
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configBarChartMachineTotal.labels.push(month + ' ' + data[i].year);
        this.configBarChartMachineTotal.valuesGold.push(data[i].total.gold);
        this.configBarChartMachineTotal.valuesPlatinum.push(data[i].total.platinum);
      };
      this.configBarChartMachineTotal.datasets.push({
        backgroundColor: '#a08066',
        label: 'Oro',
        data: this.configBarChartMachineTotal.valuesGold
      });
      this.configBarChartMachineTotal.datasets.push({
        backgroundColor: '#766357',
        label: 'Platino',
        data: this.configBarChartMachineTotal.valuesPlatinum
      });
      // pasa valores para graficar
      let datos = {
        labels : this.configBarChartMachineTotal.labels,
        datasets : this.configBarChartMachineTotal.datasets
      };
      let barchart = document.getElementById('barChartMaquinas');
      if(graficoMachinesTotal) graficoMachinesTotal.destroy();

      graficoMachinesTotal = new Chart(barchart, {
        type : "bar",
        data : datos,
        options: {
          scales: {
            yAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true
              }
            }],
            xAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true
              }
            }]
          },
          legend: {
            position: 'bottom',
            onClick: (e) => e.stopPropagation()
          }
        }
      });
    },
    renderChartMachinesPlatinum(data) {
      this.configLineChartMachinesPlatinum = {
        labels: [],
        valuesGold: [],
        averageGold: [],
        valuesPlatinum: [],
        averagePlatinum:[],
        datasets: []
      };
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configLineChartMachinesPlatinum.labels.push(month + ' ' + data[i].year);
        this.configLineChartMachinesPlatinum.valuesPlatinum.push(data[i].total.platinum);
        this.configLineChartMachinesPlatinum.averagePlatinum.push(data[i].average.platinum);
      };
      this.configLineChartMachinesPlatinum.datasets.push({
        borderColor: '#af006a',
        fill: false,
        label: 'Total de unidades',
        data: this.configLineChartMachinesPlatinum.valuesPlatinum
      });
      this.configLineChartMachinesPlatinum.datasets.push({
        borderColor: '#009cde',
        fill: false,
        label: 'Promedio de unidades',
        data: this.configLineChartMachinesPlatinum.averagePlatinum
      });
      // pasa datos para graficar
      let datos = {
        labels : this.configLineChartMachinesPlatinum.labels,
        datasets : this.configLineChartMachinesPlatinum.datasets
      };

      let lineChart = document.getElementById('lineChartMaquinasPlatino');
      if(graficoMachinesPlatinum) graficoMachinesPlatinum.destroy();

      graficoMachinesPlatinum = new Chart(lineChart, {
        type : "line",
        data : datos,
        options: {
          legend: {
            position: 'bottom',
            onClick: (e) => e.stopPropagation()
          }
        }
      });
    },
    renderChartMachinesGold(data) {
      this.configLineChartMachinesGold = {
        labels: [],
        valuesGold: [],
        averageGold: [],
        valuesPlatinum: [],
        averagePlatinum:[],
        datasets: []
      };
      for(var i = 0; i < data.length ; i++){
        let month = this.setNameMonthCharts(data[i].month);
        this.configLineChartMachinesGold.labels.push(month + ' ' + data[i].year);
        this.configLineChartMachinesGold.valuesGold.push(data[i].total.gold);
        this.configLineChartMachinesGold.averageGold.push(data[i].average.gold);
      };
      this.configLineChartMachinesGold.datasets.push({
        borderColor: '#af006a',
        fill: false,
        label: 'Total de unidades',
        data: this.configLineChartMachinesGold.valuesGold
      });
      this.configLineChartMachinesGold.datasets.push({
        borderColor: '#009cde',
        fill: false,
        label: 'Promedio de unidades',
        data: this.configLineChartMachinesGold.averageGold
      });
      // pasa datos para graficar
      let datos = {
        labels : this.configLineChartMachinesGold.labels,
        datasets : this.configLineChartMachinesGold.datasets
      };

      let lineChart = document.getElementById('lineChartMaquinasGold');
      if(graficoMachinesGold) graficoMachinesGold.destroy();

      graficoMachinesGold = new Chart(lineChart, {
        type : "line",
        data : datos,
        options: {
          legend: {
            position: 'bottom',
            onClick: (e) => e.stopPropagation()
          }
        }
      });
    },
    setNameMonth(data) {
      switch (data) {
        case 1: return data = 'Enero';
        case 2: return data = 'Febrero';
        case 3: return data = 'Marzo';
        case 4: return data = 'Abril';
        case 5: return data = 'Mayo';
        case 6: return data = 'Junio';
        case 7: return data = 'Julio';
        case 8: return data = 'Agosto';
        case 9: return data = 'Setiembre';
        case 10: return data = 'Octubre';
        case 11: return data = 'Noviembre';
        case 12: return data = 'Diciembre';
        default:
          break;
      };
    },
    setNameMonthCharts(data) {
      switch (data) {
        case 1: return data = 'Ene';
        case 2: return data = 'Feb';
        case 3: return data = 'Mar';
        case 4: return data = 'Abr';
        case 5: return data = 'May';
        case 6: return data = 'Jun';
        case 7: return data = 'Jul';
        case 8: return data = 'Ago';
        case 9: return data = 'Set';
        case 10: return data = 'Oct';
        case 11: return data = 'Nov';
        case 12: return data = 'Dic';
        default:
          break;
      };
    }
  },
});





