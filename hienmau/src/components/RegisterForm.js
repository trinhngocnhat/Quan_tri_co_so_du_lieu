import React, { useState } from "react";

function RegisterForm() {
    const [formData, setFormData] = useState({
        name: "",
        age: "",
        weight: "",
        height: "",
        email: "",
        password: "",
        gender: "",
    });

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await fetch("http://localhost:5000/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(formData),
            });

            const result = await response.json();
            alert(result.message);
        } catch (error) {
            console.error("Error registering user:", error);
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <h1 className="register">Register here</h1>
            <input type="text" name="name" placeholder="Name" onChange={handleChange} required />
            <input type="date" name="age" placeholder="Age" onChange={handleChange} required />
            <input type="number" name="weight" placeholder="Weight" onChange={handleChange} required />
            <input type="number" name="height" placeholder="Height" onChange={handleChange} required />
            <input type="email" name="email" placeholder="Email" onChange={handleChange} required />
            <input type="password" name="password" placeholder="Password" onChange={handleChange} required />
            <input type="text" name="gender" placeholder="Gender" onChange={handleChange} />
            <button type="submit">Register</button>
        </form>
    );
}

export default RegisterForm;
