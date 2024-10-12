import Footer from "@/Components/Footer";
import HeaderSearch from "@/Components/HeaderSearch";
// import Header from "@/Components/Header";
import { PageProps } from "@/types";
import React from "react";

type Props = {
    children: React.ReactNode;
};

export default function GeneralLayout({ children }: PageProps<Props>) {
    return (
        <div className="w-full">
            {children}
            <div id="footerPadder" className="w-full py-8"></div>
            <Footer />
        </div>
    );
}
