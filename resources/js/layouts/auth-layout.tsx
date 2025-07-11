import { ModalRenderer } from "@/components/ui/modal";
import { Separator } from "@/components/ui/separator";
import { Toaster } from "@/components/ui/toaster";
import { useRef } from "react";
import AppBreadcrumb from "@/components/app/app-breadcrumb";
import AppSidebar from "@/components/app/app-sidebar";
import UserMenu from "@/components/app/user/menu";
import {
  SidebarInset,
  SidebarProvider,
  SidebarTrigger,
} from "@/components/ui/sidebar";

type AuthLayoutProps = {
  children: React.ReactNode;
};

function AuthLayout({ children }: AuthLayoutProps) {
  const mainRef = useRef<HTMLDivElement>(null);

  return (
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        <header className="bg-background sticky top-0 flex h-12 items-center gap-3 border-b px-3">
          <SidebarTrigger />
          <Separator orientation="vertical" />
          <AppBreadcrumb className="grow" />
          <UserMenu />
        </header>
        <main ref={mainRef} className="relative min-h-[calc(100vh-3rem)]">
          <ModalRenderer container={mainRef.current} />
          {children}
          <Toaster />
        </main>
      </SidebarInset>
    </SidebarProvider>
  );
}

export default AuthLayout;
