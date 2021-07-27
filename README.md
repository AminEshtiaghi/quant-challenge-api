## QUANT code challenge

### About The Challenge

<p>
In thin challenge, we are going to develop a login page  which is communicating with a backend side. by logging in, we will face  with a drop down including all the currrencies, then we are able to choose one of them and by hiting the search button which is located at the  bottom of dropdown, we will see all the market information of selected currency.
</p>

<p>
for this purpose, I have decided to separate back-end and front-end code from each other in code repository level, by doing this, we will have a lot of freedom for the next steps which need to  be taken on DevOps side (DevOps was not part of challenge but it is necessary to consider those at design part). 

#### Back-end (API)
- Laravel 8 framework
- PHP 8 language
- Passport
- Sail (PHP, MySQL8, Redis Docker)

#### Front-end (APP)
- Vue
- Vuex
- Vuetify
- TypeScript
- npm
</p>

<p align="center">
Here is a diagram chart which illustrate how the systems are communicaating with each other.
</p>
<p>
<img src="https://raw.githubusercontent.com/AminEshtiaghi/quant-challenge-api/main/resources/docs/DesignChart.jpg" width="400">
</p>

#### Laravel Back-end API

Back-end API is only responsible for receiveing and resposing the front-end app.
<br />
we have two end-point regarding auth resposiblitties:
<br/>
- `/api/auth/login`
- `/api/auth/logout`
<br/>
And two API for the search page:
<br/>
- `/api/search/currencies` *this API returns TOP 100 available currency list [because of performance issues for this step, I prevent of getting all the existing currency list from 3rd party API]*
- `/api/search/details/{symbol}` *this API returns all the name, price and market information of the selected currency from the previous step which user selected.*

Except the `login` API, the rest of them are keeping secure by passport authentication system, so if you are not logged in, you will not be able to call them.

##### installation
- clone [the code](https://github.com/AminEshtiaghi/quant-challenge-api) on your system.
- `composer install`
- **Note** please make sure that your docker is running on your system.
- `vendor/bin/sail up -d`
- `vendor/bin/sail artisan migrate`
- `vendor/bin/sail artisan passport:keys`
- **Note** please make sure that the correct *nomics API key*  is set in the *.env* file (`NOMICS_KEYNOMICS_KEY`).

By doing the previous steps, your back-end project is up and running on the docker containers with following information:
- **MySQL**: `localhost:3306` | user: `sail` | pass: `password`
- **Redis**: `localhost:6379`
- **Nginx**: `localhost:80`

#### Vue Front-end APP

Front-end is a separated project which is connected with back-end by calling those 4 API which mentioned before.
The Project is a VueJS project including vuex in order to use *Store* features and specially **Vuetify** to have a very beautiful and interactive user interface.
I also use *TypeScript* in order to have a very structural model in all the segments from the view pages, components, base vue files to the store files. it really helps in debugging the code at the time, I am developing it with code annotations.

##### installation
- clone [the code](https://github.com/AminEshtiaghi/quant-challenge-app) on your system.
- `npm install`
- `npm run serve`

By now, you have this app on your browser by visiting [`lohalhost:8080`](http://localhost:80)



Finally, I want to thanks for the chance you give me to have your attention and thanks for your time spent on checking out these projects.

Yours Sincerely,
<br/>
Amin