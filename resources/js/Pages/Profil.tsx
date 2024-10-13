import Footer from "@/Components/Footer";
import GeneralLayout from "@/Layouts/GeneralLayout";
import SubPageLayout from "@/Layouts/SubPageLayout";
import React, { useEffect } from "react";
import { FaAngleLeft, FaStar } from "react-icons/fa6";

type Props = {
    auth?: object;
    season?: object;
};

const Profil = ({ auth, season }: Props) => {
    useEffect(() => {
        console.log(auth);

        return () => {};
    }, []);

    return (
        <div id="wrapper" className="w-full relative">
            {/* Header */}
            <header className="w-full fixed z-[2] top-0 flex items-center px-4 py-3">
                {/* Container */}
                <div className="mx-auto max-w-screen-lg w-full">
                    {/* Title */}
                    <h1 className="text-lg font-bold -mb-1 text-white">
                        Profil
                    </h1>
                </div>
            </header>

            {/* Second Header */}
            <div className="w-full relative">
                {/* Header */}
                <div className="w-full text-white text-center relative bg-primary/50">
                    <img
                        src="/storage/avatar/avatar1.jpeg"
                        alt=""
                        className="object-center object-cover overflow-hidden size-full absolute top-0 left-0 right-0 bottom-0 z-[-1] blur-2xl opacity-75"
                    />

                    <div className="flex items-center justify-center w-full h-[100dvh] mx-auto gap-4 px-6">
                        <div className="flex flex-col">
                            {/* Avatar */}
                            <div className="flex-1 max-w-[120px]">
                                <img
                                    src="/storage/avatar/avatar1.jpeg"
                                    alt=""
                                    className="aspect-square object-center object-cover overflow-hidden rounded-full h-[120px] w-[120px] shadow-md shadow-black/50 mx-auto"
                                />
                            </div>
                            {/* Detail */}
                            <div className="flex flex-col">
                                <p className="text-xl font-bold">
                                    {auth.user.name}
                                </p>
                                <p className="text-lg">
                                    Peringkat:{" "}
                                    <span className="">
                                        {auth.user?.level?.name}
                                    </span>
                                </p>
                                <p className="text-lg text-yellow-500">
                                    - Poin
                                </p>
                                <div className="">
                                    <a
                                        href="/logout"
                                        className="text-red-500 font-bold"
                                    >
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Content */}
                <main className="w-full mt-10 flex flex-col justify-stretch gap-y-8 px-2 py-8">
                    {/* History */}
                    {/* <section className="w-full text-black bg-gradient-to-tr from-yellow-400/50 to-yellow-500/50 px-4 py-16">
                        <h2 className="text-2xl font-bold text-center">
                            {" "}
                            Point{" "}
                        </h2>


                    </section> */}
                </main>
            </div>

            <Footer />
        </div>
    );
};

export default Profil;
