import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
// import App from './App';
import reportWebVitals from './reportWebVitals';
import Page from "./components/Page/Page";
import Counter from "./components/Counter";

const root = ReactDOM.createRoot(document.getElementById('root'));

const arr = [2, 3, 10, 34];

root.render(
    <React.StrictMode>
        <Counter value={4} min={3} max={7}/>
        <Counter value={4}/>
        {/*<App />*/}
        <Page/>
    </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
