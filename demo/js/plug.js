function toAjax(data, url) {              
    $.ajax({
        type:"POST",
        url: url,
        data: data,
        dataType:"json",
        success:function(res){  
            let html = '<span class="binding-title">Request：</span>';
            let getHeader = res.getHeader.split('\r\n');
            getHeader.forEach(el => {
                if(el !== '') {
                    html += `${el}</br>`
                }
            });
            html += '</br><span class="binding-title">Response Header：</span>';
            let header = res.header.split('\r\n');
            header.forEach(el => {
                if(el !== '') {
                    html += `${el}</br>`
                }
            });
            html += '</br><span class="binding-title">Response Body：</span>' + res.body;
            $('#ng-binding').html(html);
            $('#sendPost').show();
        },
        error:function(res){
            console.error(res);
            $('#sendPost').show();
        }
    });
};


function getRandomNumber(max, min) {
    for(let i = 0; i<10; i++) {
        let x = Math.floor(Math.random() * (max - min + 1)) + min;
        return x;
    }
};

function getCurrency() {
    const currencyList = ['USD', 'EUR', 'GBP', 'AUD', 'CHF', 'MYR', 'IDR', 'JPY', 'HKD', 'CAD', 'SGD', 'NZD', 'THB', 'KRW', 'CNY'];
    let key = getRandomNumber(currencyList.length, 1);
    return currencyList[key - 1];
}