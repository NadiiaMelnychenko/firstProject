import {useState} from "react";

// import PropTypes from "prop-types";

function Counter({value = 100, padding = 20, min = 1, max = 9}) {
    const [currentValue, setValue] = useState(value)
    return <div
        style={{padding, backgroundColor: (currentValue < min) ? "red" : ((currentValue > max)  ? "green" : "white")}}>
        <div>Value: {currentValue}</div>
        <div>
            <button onClick={() => {
                setValue(currentValue + 1)
            }}>+
            </button>
            <button onClick={() => {
                setValue(currentValue - 1)
            }}>-
            </button>
        </div>
    </div>
}

// Counter.defaultProps = {
//     value: 100
// }

export default Counter;