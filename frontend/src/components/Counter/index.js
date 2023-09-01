import {useState} from "react";

// import PropTypes from "prop-types";

function Counter({value = 100, padding = 20, color = "white"}) {
    const [currentValue, setValue] = useState(value)
    return <div style={{padding, backgroundColor: (currentValue < 0) ? color : "white"}}>
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