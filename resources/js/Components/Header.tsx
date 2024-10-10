import React from "react";
import { FaMagnifyingGlass } from "react-icons/fa6";

type Props = {};

const Header = (props: Props) => {
    return (
        <header className="w-full flex items-center fixed top-0 z-30 px-2 py-2 bg-white shadow-md">
            {/* Search */}
            <div className="w-full relative overflow-hidden rounded-lg bg-gray-100 flex flex-row items-center px-4">
                <FaMagnifyingGlass size={14} className="m-0 p-0" />

                <input
                    type="search"
                    name="search"
                    id="input-search"
                    placeholder="Search..."
                    className="w-full border-none bg-transparent outline-none text-sm text-gray-700 focus:ring-0"
                />
            </div>
        </header>
    );
};

export default Header;
