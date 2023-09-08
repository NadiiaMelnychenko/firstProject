import React, {useEffect, useState} from "react";
import {Button, MenuItem, Select, TextField} from "@mui/material";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import {responseStatus} from "../../../utils/consts";
import Notification from "../../elemets/notification/Notification";

const GoodsCreate = ({ updateProductList }) => {

    const [name, setName] = useState("");
    const [description, setDescription] = useState("about text");
    const [price, setPrice] = useState(1);
    const [category, setCategory] = useState(null);

    const [loading, setLoading] = useState(false);

    const [notification, setNotification] = useState({
        visible: false,
        type: "",
        message: ""
    });

    const [categoryList, setCategoryList] = useState([]);

    const constructData = () => {
        return {
            name: name,
            description: description,
            price: price,
            category: `${category}`
        }
    }

    const handleSubmit = (event) => {
        event.preventDefault()
        flushProduct();
    }

    const flushProduct = () => {
        setLoading(true);

        axios.post("/api/products", constructData(), userAuthenticationConfig(false))
            .then(response => {
                setNotification({...notification, visible: true, type: "success", message: "Product created"});
                updateProductList();
            })
            .catch(error => {
                setNotification({...notification, visible: true, type: "error", message: error.response.data.title});
                console.log("error");
            }).finally(() => {
            setLoading(false)
        });
    };

    const fetchCategories = () => {
        axios.get("/api/categories", userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
                setCategoryList(response.data["hydra:member"]);
            }
        }).catch(error => {
            console.log("error");
        });
    }

    useEffect(() => {
        fetchCategories();
    }, []);

    return <>
        {notification.visible &&
            <Notification
                notification={notification}
                setNotification={setNotification}
            />
        }
        <form onSubmit={handleSubmit}>
            <div>
                <TextField
                    label="Назва продукту"
                    value={name}
                    variant="filled"
                    required
                    onChange={(e) => setName(e.target.value)}
                />
            </div>
            <p></p>
            <div>
                <TextField
                    label="Ціна"
                    type="number"
                    variant="filled"
                    required
                    onChange={(e) => setPrice(e.target.value)}/>
            </div>
            <p></p>
            <div>
                <TextField
                    label="Опис"
                    value={description}
                    defaultValue="about string"
                    variant="filled"
                    onChange={(e) => setDescription(e.target.value)}
                />
            </div>
            <p></p>
            <div>
                <Select
                    onChange={(e) => {
                        setCategory(e.target.value)
                    }}
                    label="Категорія"
                    value={category}
                >
                    {categoryList && categoryList.map((item, key) => (
                        <MenuItem key={key} value={item["id"]}>{item["name"]}</MenuItem>
                    ))}
                </Select>
            </div>
            <p></p>
            <Button variant="contained" type="submit">
                Створити продукт
            </Button>
            <p></p>
        </form>
    </>
};

export default GoodsCreate;
