import { Separator } from "@/components/ui/separator";
import { Toaster } from "@/components/ui/toaster";
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
        <div className="h-[calc(100vh-3rem)] min-h-fit">
          {children}
          <Toaster />
        </div>
      </SidebarInset>
    </SidebarProvider>
  );
}

export default AuthLayout;
