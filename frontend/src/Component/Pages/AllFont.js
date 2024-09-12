import { useEffect, useState } from "react";

import Navbar from "../../Includes/Navbar";

const AllFont = () => {

    const [fonts, setFonts] = useState([]);

    useEffect(() => {

        //get faq data
        const get_fonts_url = `${window.url}/font`
        fetch(get_fonts_url, {
            method: "GET"
        })
            .then(response => response.json())
            .then(response => {
                console.log(response)
                if (response.status == true) {
                    setFonts(response.data);

                    const style = document.createElement('style');
                    response.data.forEach(font => {
                        style.textContent += `
                            @font-face {
                                font-family: '${font.name}';
                                src: url('${window.image_path}${font.path}') format('truetype');
                            }
                        `;
                    });

                    document.head.appendChild(style);

                }
            })
            .catch(response => {
                console.log(response)
            })

    }, [])

    return (
        <div className="id">
            <Navbar></Navbar>

            <section className="section-title">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <h2>All Font</h2>
                        </div>
                    </div>
                </div>
            </section>

            <section className="all-font-section">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <table className="table table-striped table-dark">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Name</th>
                                        <th>Preview</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {fonts.map((font, index) => (
                                        <tr key={font.id}>
                                            <td>{index + 1}</td>
                                            <td>{font.name}</td>
                                            <td>
                                                <p style={{ fontFamily: font.name }}>Example style</p>
                                            </td>
                                            <td>
                                                <button>Delete</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    );
}

export default AllFont;