import React, { useEffect, useState } from "react";
import axios from "axios";
import { responseStatus } from "../../../utils/consts";
import { Helmet } from "react-helmet-async";
import {Breadcrumbs, Link, Pagination, Typography} from "@mui/material";
import {NavLink, useNavigate, useSearchParams} from "react-router-dom";
import GoodsList from "./GoodsList";
import {checkFilterItem, fetchFilterData} from "../../../utils/fetchFilterData";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import GoodsFilter from "./GoodsFilter";
import GoodsCreate from "./GoodsCreate";
import DateFilter from './DateFilter';

const GoodsContainer = () => {
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();

  const [goods, setGoods] = useState(null);

  const [paginationInfo, setPaginationInfo] = useState({
    totalItems: null,
    totalPageCount: null,
    itemsPerPage: 10
  });

  const [filterData, setFilterData] = useState({
    "page": checkFilterItem(searchParams, "page", 1, true),
    "name": checkFilterItem(searchParams, "name", null),
    "price": checkFilterItem(searchParams, "price", null),
    "addTime": checkFilterItem(searchParams, "addTime", null),
  });

  function convertDateToBigInt(date) {
    return Math.floor(new Date(date).getTime() / 1000); // Переводимо дату в секунди та округлюємо
  }
  const fetchProducts = () => {
    let filterUrl = fetchFilterData(filterData);

    const { minPrice, maxPrice, startDate, endDate } = filterData;

    if (minPrice !== undefined) {
      filterUrl += `&price[gte]=${minPrice}`;

    }
    if (maxPrice !== undefined) {
      filterUrl += `&price[lte]=${maxPrice}`;
    }
    if (startDate && endDate) {
      const startDateBigInt = convertDateToBigInt(startDate);
      const endDateBigInt = convertDateToBigInt(endDate);
      filterUrl += `&addTime[gte]=${startDate}&addTime[lte]=${endDate}`;
    }

    navigate(filterUrl);

    axios.get("/api/products" + filterUrl +  "&itemsPerPage=" + paginationInfo.itemsPerPage, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setGoods(response.data["hydra:member"]);
        setPaginationInfo({
          ...paginationInfo,
          totalItems: response.data["hydra:totalItems"],
          totalPageCount: Math.ceil(response.data["hydra:totalItems"] / paginationInfo.itemsPerPage)
        });
      }
    }).catch(error => {
      console.log("error");
    });
  };

  const onChangePage = (event, page) => {
    setFilterData({ ...filterData, page: page });
  };

  useEffect(() => {
    fetchProducts();
  }, [filterData]);

  const updateProductList = () => {
    fetchProducts();
  };

  return (
    <>
      <Helmet>
        <title>
          Sign in
        </title>
      </Helmet>
      <Breadcrumbs aria-label="breadcrumb">
        <Link component={NavLink} underline="hover" color="inherit" to="/">
          Home
        </Link>
        <Typography color="text.primary">Goods</Typography>
      </Breadcrumbs>
      <Typography variant="h4" component="h1" mt={1}>
        Goods
      </Typography>
      <GoodsCreate updateProductList={updateProductList} />
      <GoodsFilter filterData={filterData} setFilterData={setFilterData}/>
      <DateFilter onDateChange={(dateRange) => setFilterData({ ...filterData, ...dateRange })} />
      <GoodsList goods={goods}/>
      {paginationInfo.totalPageCount &&
          <Pagination
              count={paginationInfo.totalPageCount}
              shape="rounded"
              page={filterData.page}
              onChange={(event, page) => onChangePage(event, page)}
          />}
    </>
  );

};

export default GoodsContainer;