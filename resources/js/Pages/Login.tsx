import { useForm } from "@inertiajs/react";
import React, { FormEventHandler, useEffect } from "react";

type Props = {
    status?: string;
};

const Login = ({ status }: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        username: "",
        password: "",
        remember: false,
    });

    // useEffect(() => {
    //     return () => {
    //         reset("password");
    //     };
    // }, []);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        post("/masuk");
    };

    return (
        <div className="w-full h-[100dvh] relative flex justify-center items-center bg-primary p-4">
            {/* Card */}
            <div className="w-full max-w-[400px] px-4 py-8 bg-white rounded-lg shadow">
                {/* Card Layout */}
                <div className="w-full h-full flex flex-col justify-center items-center gap-4">
                    {/* Title */}
                    <h1 className="text-3xl font-bold text-primary">
                        Selamat Datang
                    </h1>

                    {/* Desc */}
                    <p className="-mt-3 text-gray-500 text-sm">
                        Silahkan login untuk melanjutkan.
                    </p>

                    <form
                        onSubmit={handleSubmit}
                        className="w-full flex flex-col items-stretch gap-y-3 px-4"
                    >
                        <div className="relative">
                            <input
                                type="text"
                                name="username"
                                id="InputUsername"
                                placeholder="Username"
                                onChange={(e) =>
                                    setData("username", e.target.value)
                                }
                                className="w-full flex-1 bg-transparent text-sm border border-gray-200 rounded-md text-gray-700 focus:ring-0"
                            />
                            {errors.username && <div>{errors.username}</div>}
                        </div>
                        <div className="relative">
                            <input
                                type="password"
                                name="password"
                                id="InputPassword"
                                placeholder="Password"
                                className="w-full flex-1 bg-transparent text-sm border border-gray-200 rounded-md text-gray-700 focus:ring-0"
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                            />
                            {errors.password && <div>{errors.password}</div>}
                        </div>

                        <div className="relative">
                            <button
                                type="submit"
                                className="w-full cursor-pointer py-3 rounded-md shadow-md bg-primary text-white"
                                disabled={processing}
                            >
                                Masuk
                            </button>
                        </div>

                        <div className="relative">
                            <p className="text-xs text-center">
                                Belum punya akun?{" "}
                                <a
                                    href="/daftar"
                                    className="text-primary font-bold"
                                >
                                    Daftar sekarang.
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default Login;
