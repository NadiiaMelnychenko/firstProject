class User {
    #login;
    #pass;

    constructor(login, pass) {
        this.#login = login;
        this.#pass = pass;
    }

    getLogin() {
        return this.#login;
    }

    testPassword(pass) {
        return this.#pass === pass;
    }
}

class Admin extends User {
    #role;

    constructor(login, pass, role) {
        super(login, pass);
        this.#role = role;
    }
}

const user = new User('admin', '123456');
const admin = new Admin('admin', '123456', 'all');

console.log(user.testPassword('123456'));

let page = {
    id: 2,
    title: "smth",
    changeTitle: function (title) {
        this.title = title;
    }
}

let str = `${user.getLogin()} text `;


//-----------------------------------------------------------------------------------
let arr = [
    {
        "name": "one",
        "age": 19,
        "title": "text",
    },
    {
        "name": "two",
        "age": 19,
        "title": "text",
    },
    {
        "name": "three",
        "age": 19,
        "title": "text",
    },
];

class UserPanels {
    #userArray;
    #stateArray;

    constructor(userArray) {
        this.#userArray = userArray;
        this.#stateArray = new Array(this.#userArray.length);

        for (let i = 0; i < this.#stateArray.length; i++) {
            this.#stateArray[i] = false;
        }
        this.#build();
    }

    saveState() {
        localStorage.setItem('panels-state', JSON.stringify(this.#stateArray));
    }

    loadState() {
        if (localStorage.getItem('panels-state')) {
            this.#stateArray = JSON.parse(localStorage.getItem('panels-state'));
        }
    }

    #build() {
        this.loadState();
        let containerTag = document.createElement('div');

        for (let i = 0; i < this.#userArray.length; i++) {
            let divTag = document.createElement('div');
            divTag.classList.add('user');
            divTag.dataset['id'] = i.toString();
            if (this.#stateArray[i]) {
                divTag.classList.add('selected');
            }
            for (let field in this.#userArray[i]) {
                let val = this.#userArray[i][field];
                let divField = document.createElement('div');
                divField.classList.add(field);
                divField.innerHTML = val;
                divTag.appendChild(divField);
            }
            containerTag.appendChild(divTag);
        }
        document.body.appendChild(containerTag);

        document.documentElement.addEventListener('click', (event) => {
            let tag = event.target;
            tag = tag.closest('.user')

            if (tag?.classList.contains('user')) {
                let id = tag.dataset['id'];
                this.#stateArray[id] = !this.#stateArray[id];
                this.saveState();
                tag.classList.toggle('selected');
            }
        });
    }
}

let userPanels = new UserPanels(arr);