// функция get
function httpGet(url) {
    return new Promise(function(resolve, reject) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onload = function() {
            if (this.status === 200) {
                resolve(JSON.parse(this.response));
            } else {
                const error = new Error(this.statusText);
                error.code = this.status;
                reject(error);
            }
        };
        xhr.onerror = function() {
            reject(new Error("Network Error"));
        };
        xhr.send();
    });
}
// функция post
function httpPost(url, requestBody) {
    return new Promise(function(resolve, reject) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                resolve(this.responseText);
            } else {
                const error = new Error(this.statusText);
                error.code = this.status;
                reject(error);
            }
        };
        xhr.onerror = function() {
            reject(new Error("Network Error"));
        };
        xhr.send(requestBody);
    });
}
// форматирование времени
function formatDate(date) {
    return (date).split('-')[2]+'.'+(date).split('-')[1]+'.'+(date).split('-')[0]
}
// формирует новости
function shapingNews(data) {
    let news = '';
    data.map((currentValue) => {
        currentValue['date'] = formatDate(currentValue['date'])
        news += `<article class="articleNews"><img src="/image/news/${currentValue['id']}/imagePreview/previewPhoto.jpg" alt="${currentValue['title']}" class="articleNews__img"><h3 class="articleNews__h3"><a href="/новость.php?id=${currentValue['id']}">${currentValue['title']}</a></h3> <div class="articleNews__heading"><span>${currentValue['date']}</span></div><p class="articleNews__preview">${currentValue['preview']}</p><a href="/новость.php?id=${currentValue['id']}" class="articleNews__readMore">Читать полностью &gt;&gt;</a></article>`
    })
    return news
}
//*******************************
//* выводит постранично новости *
//*******************************
function generateNews (value) {
    httpGet(`/request/requests.php?getAllNews=${value}`)
        .then(
            response => {
                let news = shapingNews(response)
                scrollTo(0,0)
                $('.aside__pages__page').removeClass('activePage')
                $(`#${value}`).addClass('activePage')
                $('#news').empty().append(news)
            },
            error => alert(`Rejected: ${error}`)
        );
}
//*****************************
//* выводит найденные новости *
//*****************************
function search() {
    let value = document.getElementById("searchValue").value;
    if (value === ''){ return }
    httpGet(`/request/requests.php?checkSearch=${value}`)
        .then(
            response => {
                //если есть совпадения то выводим карточки
                if (response[0]['kolvo'] > 0){
                    $('.aside__result-search').css('display', 'block').empty().append(`<h3>Найдено совпадений: ${response[0]['kolvo']}</h3><br><div><a href="/новости.php/">Сбросить</a></div>`)
                    let news = `<div class="result-search"><h3 class="result-search__h3">Результат поиска для: ${value}</h3></div>`;
                    httpGet('/request/requests.php?getSearch='+value)
                        .then(
                            response => {
                                news += shapingNews(response)
                                $('.aside__pages').css('display', 'none')
                                $('#news').empty().append(news)
                            },
                            error => alert(`Rejected: ${error}`)
                        );
                }else{ //иначе выводим сообщение
                    $('.aside__result-search').css('display', 'block').empty().append(`<h3>Совпадений не найденно</h3><br><div><a href="/новости.php/">Сбросить</a></div>`)
                    $('.aside__pages').css('display', 'none')
                }
            },
            error => alert(`Rejected: ${error}`)
        );
}