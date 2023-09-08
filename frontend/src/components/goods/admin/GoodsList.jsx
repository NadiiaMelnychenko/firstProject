import React from "react";
import GoodsItem from "./GoodsItem";
import { Table, TableHead, TableBody, TableRow, TableCell, Paper } from "@mui/material";

const GoodsList = ({ goods }) => {
    return <>
        <Paper>
            <Table>
                <TableHead>
                    <TableRow>
                        <TableCell>Назва</TableCell>
                        <TableCell>Ціна</TableCell>
                        <TableCell>Дата додавання</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {goods && goods.map((item, index) => (
                        <GoodsItem key={index} good={item} />
                    ))}
                </TableBody>
            </Table>
        </Paper>
    </>
};

export default GoodsList;