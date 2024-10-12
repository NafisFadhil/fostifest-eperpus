import Footer from "@/Components/Footer";
import HeaderSubPage from "@/Components/HeaderSubPage";
import React from "react";
import GeneralLayout from "./GeneralLayout";

type Props = {
    children: React.ReactNode;
    navbarTitle: string | undefined;
};

function SubPageLayout({ children, navbarTitle }: PageProps<Props>) {
    return (
        <GeneralLayout>
            <HeaderSubPage title={navbarTitle} />
            {children}
        </GeneralLayout>
    );
}

export default SubPageLayout;
