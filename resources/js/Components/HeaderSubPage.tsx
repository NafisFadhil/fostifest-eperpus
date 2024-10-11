import React from "react";
import { FaAngleLeft } from "react-icons/fa6";

type Props = {};

const HeaderSubPage = (props: Props) => {
    return (
        <>
            <header className="w-full fixed z-[2] top-0 flex items-center px-4 py-3">
                {/* Container */}
                <div className="mx-auto max-w-screen-lg w-full text-center">
                    <a
                        href="/"
                        className="hover:opacity-75 transition max-w-max flex items-center bg-white/5 text-white rounded-full px-2 py-1 cursor-pointer"
                    >
                        <FaAngleLeft size={20} className="" />
                        <span className="text-sm">Kembali</span>
                    </a>

                    {/* <h1 className="text-lg font-bold -mb-1"> Detail Buku </h1> */}
                </div>
            </header>
            {/* <div id="headerPadder" className="w-full py-5"></div> */}
        </>
    );
};

export default HeaderSubPage;
