
let cityBtn = document.querySelector(".cities-btn"),
    sightseenBtn = document.querySelector(".sightseens-btn"),
    usersBtn = document.querySelector(".users-btn");

let resultBlock = document.querySelector('.result-block');

let reqObj = {
    'cities' : 'cities',
    'sightseens' : 'sightseens',
    'users' : 'users',
    'citySight' : 'citySight',
    'userCities' : 'userCities',
    'userSights' : 'userSights'
};

function ajaxHandler (url, calb) {
    let request = new XMLHttpRequest();
    request.open('GET', url);
    request.responseType = 'json';
    request.onload = () => {
        if (request.status != 200) {
            console.log(`Ошибка ${request.status}: ${request.statusText}`);
        } else { 
            let data = request.response;

            calb.bind(this, data)()
        }
    };
    request.send();
}


function getCitySight (id , flag) {
    if (flag == 'cities') {
        ajaxHandler(('/controllers/mainController.php?' + reqObj.citySight +"=" + id), (data)=>{
            rendCitySight(id, data, flag); 
        })
    }
    if (flag == 'users') {
        ajaxHandler(('/controllers/mainController.php?' + reqObj.userCities +"=" + id), (data)=>{
            rendCitySight(id, data, flag); 
        })
    }
};
function rendCitySight (id , data, flag) {
    let ol = document.createElement('ol');
    ol.style.marginLeft = '10px';

    if (flag == 'cities') {
        let cityTarget= document.querySelector(`[data-city-id='${id}']`);
        data.forEach(({distance_km, sightseen_name}, index) => {
            let li = document.createElement('li')
            li.setAttribute('data-city-id', id)
            li.textContent = `${++index}) ${sightseen_name} растояние от центра ${distance_km}км`
            ol.append(li)
        })

        ol.addEventListener('click', () => {
            userHandler(ol , 'cities')
        }, {once: true})
        cityTarget.append(ol)
    }
    if (flag == 'users') {
        let userTarget= document.querySelector(`[data-user-id='${id}']`);
        data.forEach(({name}, index) => {
            let li = document.createElement('li')
            li.setAttribute('data-user-id', id)
            li.textContent = `${++index}) посетил ${name}`
            ol.append(li)
        })

        ol.addEventListener('click', () => {
            userHandler(ol, 'users')
        }, {once: true})
        userTarget.append(ol)
    }
};

function userHandler (start, flag) {
    let that = window.event.target
    if (flag == 'cities' ) {
        let {cityId} = that.dataset
        ajaxHandler(('/controllers/mainController.php?cityUsers=' + cityId), (data)=>{
            let ol = document.createElement('ol')
            ol.style.marginLeft = '10px'
            data.forEach(({name}, index) => {
                let li = document.createElement('li')
                li.textContent = `${++index}) В этом городе был ${name}`
                ol.append(li)
            })
            start.innerHTML += '<hr>'
            start.append(ol)
        })
    }
    if (flag == 'users' ) {
        let {userId} = that.dataset
        ajaxHandler(('/controllers/mainController.php?userSights=' + userId), (data)=>{
            let ol = document.createElement('ol')
            ol.style.marginLeft = '10px'
            data.forEach(({name_sightseen}, index) => {
                let li = document.createElement('li')
                li.textContent = `${++index}) побывал в ${name_sightseen}`
                ol.append(li)
            })
            start.innerHTML += '<hr>'
            start.append(ol)
        })
    }
}


function rendCityOrUser (container, data, flag) {
    container.innerHTML = "";
    let ul = document.createElement('ul');
    ul.className = "result-wrap";
    container.append(ul);
    for (let i = 0; i <= data.length - 1; i++) {
        let li = document.createElement('li');
        li.textContent = data[i].name;
        li.className = "result-elems";
        if (flag == 'cities') {
            li.dataset.cityId = data[i].id;
            li.classList.add("data-cities"); 
        }
        if (flag == 'users') {
            li.dataset.userId = data[i].id;
            li.classList.add("data-users");
        }
        ul.append(li);
    }
    if(flag == 'cities') {
        renderedCity = document.querySelectorAll('.data-cities');
        renderedCity.forEach((el) => {
                el.addEventListener('click', function () {
                    let id = this.dataset.cityId;
                    getCitySight(id , 'cities' );
                }, {once: true})
            } );
    }
    if(flag == 'users') {
        renderedCity = document.querySelectorAll('.data-users');
        renderedCity.forEach((el) => {
                el.addEventListener('click', function () {
                    let id = this.dataset.userId;
                    getCitySight(id, 'users');
                }, {once: true})
            } );
    }
}

function rendSights (container, data) {
    container.innerHTML = "";
    let ul = document.createElement('ul');
    ul.className = "result-wrap";
    container.append(ul);
    for (let i = 0; i <= data.length - 1; i++) {
        let li = document.createElement('li');
        li.className = "result-elems";
        for (let key in data[i]) {
            if (data[i].hasOwnProperty(key)) {
                let span = document.createElement('span');
                span.textContent = (key === 'distance_km' ? ' Растояние до центра города, в км: ' : '') + data[i][key];
                if (key === 'rating') {
                    span.textContent = 'Рейтинг достопримечательности => ' + data[i][key];
                }
                span.className = "result-items";
                li.append(span);
            }
        }
        ul.append(li);
    }
}

cityBtn.addEventListener ('click', function () {
    ajaxHandler(('/controllers/mainController.php?' + reqObj.cities +'=true'), (data)=>{
        rendCityOrUser (resultBlock, data, 'cities')
    })
})
sightseenBtn.addEventListener ('click', function () {
    ajaxHandler(('/controllers/mainController.php?' + reqObj.sightseens +"=true"), (data)=>{
        rendSights(resultBlock, data);
    })
})

usersBtn.addEventListener ('click', function () {
    ajaxHandler(('/controllers/mainController.php?' + reqObj.users +"=true"), (data)=>{
        rendCityOrUser (resultBlock, data, 'users')
    })
})

