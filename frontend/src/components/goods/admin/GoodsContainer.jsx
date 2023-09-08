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

  const fetchProducts = () => {
    let filterUrl = fetchFilterData(filterData);

    const { minPrice, maxPrice, startDate, endDate } = filterData;

    if (minPrice !== undefined) {
      filterUrl += `&price[gte]=${minPrice}`;
      filterUrl = filterUrl.replace(`&minPrice=${minPrice}`, "");
    }

    if (maxPrice !== undefined) {
      filterUrl += `&price[lte]=${maxPrice}`;
      filterUrl = filterUrl.replace(`&maxPrice=${maxPrice}`, "");
    }

    if (startDate && endDate) {
      filterUrl += `&addTime[gte]=${startDate}&addTime[lte]=${endDate}`;
      filterUrl = filterUrl.replace(`&startDate=${startDate}`, "");
      filterUrl = filterUrl.replace(`&endDate=${endDate}`, "");
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
      {paginationInfo.totalPageCount > 1 &&
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