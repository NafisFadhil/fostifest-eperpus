import Footer from "@/Components/Footer";
import Header from "@/Components/Header";
import { PageProps } from "@/types";
import React from "react";

type Props = {
    children: React.ReactNode;
};

export default function GeneralLayout({ children }: PageProps<Props>) {
    return (
        <div className="w-full">
            <Header />
            <div id="headerPadder" className="w-full py-6"></div>
            {children}
            <div id="footerPadder" className="w-full py-8"></div>
            <Footer />
        </div>
    );
}
