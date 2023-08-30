function ExampleTable(){
    return <table className="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Upvotes</th>
            <th>Downvotes</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Alice</td>
            <td>10</td>
            <td>11</td>
        </tr>
        <tr>
            <td>Bob</td>
            <td>4</td>
            <td>3</td>
        </tr>
        <tr>
            <td>Charlie</td>
            <td>7</td>
            <td>9</td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>Totals</td>
            <td>21</td>
            <td>23</td>
        </tr>
        </tfoot>
    </table>
}

export default ExampleTable;