let jsonArr = [
    {
        "id": "1",
        "title": "text1",
        "amount": 15,
        "price": 10
    },
    {
        "id": 2,
        "title": "text2",
        "amount": 12,
        "price": 10
    },
    {
        "id": 3,
        "title": "text3",
        "amount": 5,
        "price": 10
    },
];

let tableArray = ['№', 'Назва', 'Кількість', "Ціна", 'Cума'];

class UserPanels {
    #userArray;

    constructor(userArray) {
        this.#userArray = userArray;
        this.#build();
    }

    buildTh(arr){

    }

    #build() {
        let all = 0;
        let containerTag = document.createElement('table');

        let trTag = document.createElement('tr');
        for (let i = 0; i < tableArray.length; i++) {
            let thTag = document.createElement('th');
            thTag.innerHTML = tableArray[i];
            trTag.appendChild(thTag);
        }
        containerTag.appendChild(trTag);

        for (let i = 0; i < this.#userArray.length; i++) {
            let mainTrTag = document.createElement('tr');
            for(let filed in this.#userArray[i]){
                let tdTag = document.createElement('td');
                tdTag.innerHTML = this.#userArray[i][filed];
                mainTrTag.appendChild(tdTag);
            }
            let summ = document.createElement('td');
            let countAll = this.#userArray[i].price * this.#userArray[i].amount
            all += countAll;
            summ.innerHTML = countAll;
            summ.classList.add('genAmount');
            mainTrTag.appendChild(summ);
            containerTag.appendChild(mainTrTag);
        }
        let mainTrTag = document.createElement('tr');
        let endTd = document.createElement('td');
        endTd.setAttribute('colspan', "2");
        endTd.innerHTML = 'Загальна вартість:'
        mainTrTag.appendChild(endTd);

        let endTd2 = document.createElement('td');
        endTd2.innerHTML = all;
        endTd2.setAttribute('colspan', "3");
        mainTrTag.appendChild(endTd2);
        containerTag.appendChild(mainTrTag);
        document.body.appendChild(containerTag);
    }
}

let userPanels = new UserPanels(jsonArr);
