
import { useHistory } from "react-router-dom";
import { useEffect, useState } from "react";
import Navbar from "../../Includes/Navbar"

const FontGroupComponent = (props) => {

    {/* window scroll to top */ }
    // window.scrollTo(0, 0);

    const [rows, setRows] = useState([{ id: 1, fontName: '', fontType: '', specificSize: '', priceChange: '' }]);

    const appendRow = () => {
        setRows([
            ...rows,
            { id: rows.length + 1, fontName: '', fontType: '', specificSize: '', priceChange: '' }
        ]);
    };

    // Function to remove a row by index
    const removeRow = (index) => {
        const updatedRows = rows.filter((row, i) => i !== index);
        setRows(updatedRows);
    };

    const updateRow = (index, field, value) => {

        if ((field === 'specificSize' || field === 'priceChange') && value < 0) {
            alert(`${field} cannot be less than 0`);
            return;
        }

        const updatedRows = rows.map((row, i) =>
            i === index ? { ...row, [field]: value } : row
        );
        setRows(updatedRows);
    };

    const getFonts = () => {
        const get_fonts_url = `${window.url}?dispatch=Font.index`;
        fetch(get_fonts_url, {
            method: "GET",

        })
            .then(response => response.json())
            .then(response => {
                if (response.status === true) {
                    setFonts(response.data);
                }
            })
            .catch(error => {
                console.log(error);
            });
    };
    const [fonts, setFonts] = useState([]);

    const getFontGroup = () => {
        const get_font_group_url = `${window.url}?dispatch=FontGroup.index`;
        fetch(get_font_group_url, {
            method: "GET",

        })
            .then(response => response.json())
            .then(response => {
                if (response.status === true) {
                    setAllFontGroup(response.data);
                }
            })
            .catch(error => {
                console.log(error);
            });
    };
    const [allFontGroup, setAllFontGroup] = useState([]);

    useEffect(() => {
        getFontGroup();
        getFonts();
    }, []);

    const [fontGroupName, setFontGroupName] = useState(null);
    function createFontGroup() {
        if (rows.length <= 0) {
            alert("Please add atleast one row")
            return;
        }

        if (window.confirm("Are you sure you want to create font group?")) {
            if (!fontGroupName) {
                alert("Please enter the font group name")
                return;
            }

            const fontNames = fonts.map(font => font.name);

            const emptyKeys = new Set(); // Use a Set to avoid duplicate keys

            rows.forEach(value => {
                Object.entries(value).forEach(([index, data]) => {
                    if (data === '' || data === null || data === undefined) {
                        emptyKeys.add(index); // Add the key to the Set
                    }
                });
            });

            if (emptyKeys.size > 0) {
                alert(`The following fields have empty values: ${[...emptyKeys].join(', ')}`);
            }

            const formData = new FormData();
            formData.append("groupName", fontGroupName);
            formData.append("rowData", JSON.stringify(rows));

            const delete_font_url = `${window.url}?dispatch=Font.delete`;
            const options = {
                method: "POST",
                body: formData
            };

            // fetch(delete_font_url, options)
            //     .then(response => response.json())
            //     .then(response => {
            //         alert(response.message)
            //         if (response.status == true) {
            //             // history.push("/all-font")
            //             getFonts();
            //         }
            //     })
            //     .catch(response => {
            //         console.log(response)
            //     })

        }
    }

    return (
        <div className="id">
            <Navbar></Navbar>

            <section className="section-title">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <h2>Manage Font Groups</h2>
                        </div>
                    </div>
                </div>
            </section>

            {/* create font group */}
            <section className="font-group">
                <div className="container">

                    <div className="row font-group-row">

                        {/* submit button */}
                        <div className="col-md-12 form-group text-right">
                            <button type="button" className="btn btn-sm btn-info" onClick={createFontGroup}>
                                Submit
                            </button>
                        </div>

                        {/* group name */}
                        <div className="col-md-12 form-group">
                            <label>Group Name</label>
                            <input type="text" onInput={(e) => setFontGroupName(e.target.value)} className="form-control"></input>
                        </div>

                        {/* add row */}
                        <div className="col-md-12 form-group">
                            <button type="button" className="btn btn-sm btn-success" onClick={appendRow}>
                                +
                            </button>
                        </div>

                        {/* fonts container */}
                        <div className="col-md-12 form-group fonts-container">

                            {rows.map((row, index) => (
                                <div className="row fonts-row" key={row.id}>
                                    {/* Font Name Input */}
                                    <div className="col-md-3">
                                        <input
                                            type="text"
                                            className="form-control"
                                            placeholder="Font Name"
                                            value={row.fontName}
                                            onChange={(e) => updateRow(index, 'fontName', e.target.value)}
                                        />
                                    </div>

                                    {/* Font Type Select */}
                                    <div className="col-md-4">
                                        <select
                                            className="form-control"
                                            value={row.fontType}
                                            onChange={(e) => updateRow(index, 'fontType', e.target.value)}
                                        >
                                            <option value="" disabled>Select Font</option>
                                            {fonts.map((font) => (
                                                <option key={font.id} value={font.name}>
                                                    {font.name}
                                                </option>
                                            ))}
                                            {/* Add more options as needed */}
                                        </select>
                                    </div>

                                    {/* Specific Size Input */}
                                    <div className="col-md-2">
                                        <input
                                            type="number"
                                            step="0.01"
                                            className="form-control"
                                            placeholder="Specific Size"
                                            value={row.specificSize}
                                            onChange={(e) => updateRow(index, 'specificSize', e.target.value)}
                                        />
                                    </div>

                                    {/* Price Change Input */}
                                    <div className="col-md-2">
                                        <input
                                            type="number"
                                            step="0.01"
                                            className="form-control"
                                            placeholder="Price Change"
                                            value={row.priceChange}
                                            onChange={(e) => updateRow(index, 'priceChange', e.target.value)}
                                        />
                                    </div>

                                    {/* Remove Row Button */}
                                    <div className="col-md-1 text-right d-block">
                                        <button
                                            type="button"
                                            className="btn btn-sm btn-danger remove-row"
                                            onClick={() => removeRow(index)}
                                        >
                                            X
                                        </button>
                                    </div>
                                </div>
                            ))}


                        </div>


                    </div>

                </div>
            </section>
            {/* create font group */}


            {/* font group data */}
            <section className="all-font-section">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <table className="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Font Group Name</th>
                                        <th>Fonts</th>
                                        <th>Count</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {allFontGroup.map((value, key) => (
                                        <tr key={value.id}>
                                            <td>{key + 1}</td>
                                            <td>{value.font_group_name}</td>
                                            <td>
                                                {value.font_group_data.map((data, index) => (
                                                    <span key={index} className="badge badge-info">{data.font_name}</span>
                                                ))}
                                            </td>
                                            <td>
                                                {value.font_group_data.length}
                                            </td>
                                            <td>
                                                <button className="btn btn-sm btn-warning">Edit</button>
                                                <button className="btn btn-sm btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            {/* font group data */}

        </div>
    );
}

export default FontGroupComponent;