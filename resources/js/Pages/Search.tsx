import HeaderSearch from "@/Components/HeaderSearch";
import GeneralLayout from "@/Layouts/GeneralLayout";
import { Head } from "@inertiajs/react";
import React from "react";

type Props = {};

const SearchPage = (props: Props) => {
    return (
        <GeneralLayout>
            <Head title="Pencarian" />

            <HeaderSearch />

            <main className="w-full bg-primary h-[100dvh]">
                <div className="w-full h-[500px] bg-gradient-to-tr from-primary via-primary to-secondary">
                    <div className="w-full prose max-w-none">
                        <h1 className=""></h1>
                    </div>
                </div>
                <div className="w-full max-w-screen-lg mx-auto"></div>
            </main>
        </GeneralLayout>
    );
};

export default SearchPage;
