import Chart from 'chart.js';
import Vue from 'vue';

new Vue({
  el: '#app',
  data: {
    tab: 'first'
  },
  mounted() {

  },
  methods: {

  }

});


// ***TAB MENU FILTRO***
const navTabs = () => {
  const bindAll = () => {
    const menuElements = document.querySelectorAll('[data-navtab]');
    for(let i = 0; i < menuElements.length ; i++) {
      menuElements[i].addEventListener('click', change, false);
    }
  }

  const clear = () => {
    const menuElements = document.querySelectorAll('[data-navtab]');
    for(let i = 0; i < menuElements.length ; i++) {
      menuElements[i].classList.remove('active');
      let id = menuElements[i].getAttribute('data-navtab');
      document.getElementById(id).classList.remove('active');
    }
  }

  const change = (e) => {
    clear();
    e.target.classList.add('active');
    let id = e.currentTarget.getAttribute('data-navtab');
    document.getElementById(id).classList.add('active');
  }

  bindAll();
}
let connectNavtab = new navTabs();
const navTabsCanjes = () => {
  const bindAll = () => {
    const menuElements = document.querySelectorAll('[data-canjes]');
    for(let i = 0; i < menuElements.length ; i++) {
      menuElements[i].addEventListener('click', change, false);
    }
  }

  const clear = () => {
    const menuElements = document.querySelectorAll('[data-canjes]');
    for(let i = 0; i < menuElements.length ; i++) {
      menuElements[i].classList.remove('active');
      let id = menuElements[i].getAttribute('data-canjes');
      document.getElementById(id).classList.remove('active');
    }
  }

  const change = (e) => {
    clear();
    e.target.classList.add('active');
    let id = e.currentTarget.getAttribute('data-canjes');
    document.getElementById(id).classList.add('active');
  }

  bindAll();
}
let connectNa = new navTabsCanjes();
const navTabsMaq = () => {
  const bindAll = () => {
    const menuElements = document.querySelectorAll('[data-maquinas]');
    for(let i = 0; i < menuElements.length ; i++) {
      menuElements[i].addEventListener('click', change, false);
    }
  }

  const clear = () => {
    const menuElements = document.querySelectorAll('[data-maquinas]');
    for(let i = 0; i < menuElements.length ; i++) {
      menuElements[i].classList.remove('active');
      let id = menuElements[i].getAttribute('data-maquinas');
      document.getElementById(id).classList.remove('active');
    }
  }

  const change = (e) => {
    clear();
    e.target.classList.add('active');
    let id = e.currentTarget.getAttribute('data-maquinas');
    document.getElementById(id).classList.add('active');
  }

  bindAll();
}
let connectMaq = new navTabsMaq();

// charts js

let platinumChart = document.getElementById("platinochart");
let platinoChartOptions = new Chart(platinumChart, {
  type: 'line',
  data: {
    labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
    datasets: [{
        data: [86,114,106,106,107,111,133,221,783,2478],
        label: "Total de unidades",
        backgroundColor: "#009cde",
        borderColor: "#009cde",
        fill: false
      }, {
        data: [282,350,411,502,635,809,947,1402,3700,5267],
        label: "Promedio de unidades",
        backgroundColor: "#af006a",
        borderColor: "#af006a",
        fill: false
      }
    ]
  },
  options: {
    legend: {
      position: 'bottom'
    }
  }
});

/* -----------------------------------------------------------------------
-----------------------------MONTHPICKER----------------------------------
-------------------------------------------------------------------------*/
{
  const isHidden = (e) => {

    let getNameIdInputGnrl = e.target.getAttribute('data-id');
    let inputCalendar = document.getElementById(getNameIdInputGnrl);
    let id =  e.target.getAttribute('data-target');
    let el = document.getElementById(id);
    let inputCalendarValue = inputCalendar.value.split(' ');
    inputCalendar.value = inputCalendarValue[0] + ' ' + document.getElementById('yearpicker').value;

  }

  document.addEventListener("click", function(e){
    // console.log('clic');
    let clic = e.target;
      const yearSelected = document.getElementById('yearpicker');
      const calendarPicker = document.getElementsByClassName('picker-container');
      const input = document.getElementsByClassName('monthpicker');
      if(calendarPicker[0].style.display == "block" && clic != yearSelected){
        let flag = false;
        for (var i = 0; i < input.length; i++) {
          if (clic == input[i]) flag = true;
        };
        if (!flag) calendarPicker[0].style.display = "none";
      }

  }, false);

  const createElementDOM = (e) => {
    if(document.getElementById(e.target.getAttribute('data-target')) != null){
      let top = document.getElementById(e.target.getAttribute('data-target')).parentElement;
      let nested = document.getElementById(e.target.getAttribute('data-target'));
      top.removeChild(nested);
    };

    const calendarPicker = document.getElementsByClassName('picker-container');
    for(let i = 0; i < calendarPicker.length; i++) {
      let top = calendarPicker[i].parentElement;
      let nested = calendarPicker[i];
      top.removeChild(nested);
    }

    let child = document.createElement("div");
    let father = document.getElementById(e.target.getAttribute('data-id'));

    child.setAttribute("class","picker-container");
    let idpicker = 'calendarPicker';

    e.target.setAttribute('data-target', idpicker);

    child.setAttribute("id", idpicker);
    child.setAttribute("style", 'display: block');

    let title = document.createElement("div");
    title.setAttribute('class', 'title-header');

    let year = document.createElement("select");
    let idyear = 'yearpicker';
    year.setAttribute('id',idyear);
    year.setAttribute('class', 'yearpicker');

    for (var i = 2015; i <= 2020 ; i++) {
      let option = document.createElement("option");
      option.setAttribute('value', i);
      option.innerHTML = i;

      year.appendChild(option);
    };

    title.appendChild(year);

    let body = document.createElement("div");
    body.setAttribute('class', 'body-picker');


    var meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'];
    var mesesval = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    for (var i = 0; i < 12; i++) {
      let month = document.createElement("button");
      month.setAttribute('class', 'elm-picker');
      month.setAttribute('data-target', e.target.getAttribute('data-id'));
      month.setAttribute('data-year', idyear);
      month.setAttribute('value', mesesval[i]);
      month.innerHTML = meses[i];

      body.appendChild(month);
    };

    child.appendChild(title);
    child.appendChild(body);
    // console.log(father);
    father.after(child);

    let month = document.getElementsByClassName('elm-picker');

    for(let i = 0; i < month.length; i++) {
      month[i].addEventListener('click', (e) => {
        document.getElementById(e.target.getAttribute('data-target')).value = e.target.value + ' '
            + document.getElementById(e.target.getAttribute('data-year')).value;
      });
    }
  };


  let monthPicker = document.getElementsByClassName('monthpicker');
  for(let i = 0; i < monthPicker.length; i++) {
    monthPicker[i].addEventListener('click', createElementDOM);
  }
  // /*------------------------------------------------------- */
  // capsules montpicker
  const capsulesAllInitMonth = document.getElementById('capsulasalluserinit');
  const capsulesAllEndMonth = document.getElementById('capsulasalluserend');
  const capsulesPlatinumInitMonth = document.getElementById('capsulasplatinoinit');
  const capsulesPlatinumEndMonth = document.getElementById('capsulasplatinoend');
  const capsulesGoldInitMonth = document.getElementById('capsulesgoldinit');
  const capsulesGoldEndMonth = document.getElementById('capsulesgoldend');

  // changes monthpicker
  const changesAllInitMonth = document.getElementById('canjesplatinoallinit');
  const changesAllEndMonth = document.getElementById('canjesplatinoallend');
  const changesPlatinumInitMonth = document.getElementById('canjesplatinoinit');
  const changesPlatinumEndMonth = document.getElementById('canjesplatinoend');
  const changesGoldInitMonth = document.getElementById('changesgoldinit');
  const changesGoldEndMonth = document.getElementById('changesgoldend');
  // machine monthpickes
  const machineAllInitMonth = document.getElementById('maquinaalluserinit');
  const machineAllEndMonth = document.getElementById('maquinaalluserend');
  const machinePlatinumInitMonth = document.getElementById('machineplatinoinit');
  const machinePlatinumEndMonth = document.getElementById('machineplatinoend');
  const machineGoldInitMonth = document.getElementById('machinegoldinit');
  const machineGoldEndMonth = document.getElementById('machinegoldend');
}
// Peticiones Ajax

// const requestAjaxCapsules = (periodCapsulesTotalParameters) => {
//   periodCapsulesTotalParameters = {
//     starMonth: startMonthCapsulesTotal,
//     startYear: startYearCapsulesTotal,
//     endMonth: endMonthCapsulesTotal,
//     endYear: endYearCapsulesTotal
//   };
//   const request = new XMLHttpRequest();
//   const urlApi = `/reports/capsules/capsules-total?start_month=${startMonth.startMonthCapsulesTotal}&start_year=${startYear.startYearCapsulesTotal}&end_month=${endMonth.endMonthCapsulesTotal}&end_year=${endYear.endYearCapsulesTotal}`;
//   request.open('GET', urlApi);
//   request.onload = functionInitial;
//   // request.onerror = handlError;
//   request.send();
// }
// const functionInitial = () => {}
const capsulesAllUserStartPeriod = document.getElementById('capsulasalluserinit');
const capsulesAllUserEndPeriod = document.getElementById('capsulasalluserend');

capsulesAllUserEndPeriod.addEventListener('click', evt => {
  let startMonth;
  let startYear;
  let endMonth;
  let endYear;
  startMonth = capsulesAllUserStartPeriod.value.split(' ')[0];
  startYear = capsulesAllUserStartPeriod.value.split(' ')[1];
  endMonth = capsulesAllUserEndPeriod.value.split(' ')[0];
  endYear = capsulesAllUserEndPeriod.value.split(' ')[1];
  console.log(`startMonth ${startMonth}, startYear ${startYear}, endMonth ${endMonth}, endYear ${endYear}`);
})
 const peticionAjaxCapsules = (startMonth, startYear, endMonth, endYear) => {
  const xhr = new XMLHttpRequest()
  xhr.open('GET', `/reports/capsules/capsules-total?start_month=${startMonth}&start_year=${startYear}&end_month=${endMonth}&end_year=${endYear}`, true)

  // Qué se debe hacer con la data?
  xhr.addEventListener('load', e => {
      console.log(e.target)
      // c.innerHTML = e.target.responseText
  })

  // Realice la petición
  xhr.send()
 }
