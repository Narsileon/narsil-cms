import { ModalRenderer } from "@/components/ui/modal";
import { Separator } from "@/components/ui/separator";
import { Toaster } from "@/components/ui/toaster";
import { useEffect, useRef } from "react";
import { useMaxLg } from "@/hooks/use-breakpoints";
import AppBreadcrumb from "@/components/app/app-breadcrumb";
import AppSidebar from "@/components/app/app-sidebar";
import useAuth from "@/hooks/use-auth";
import useColorStore from "@/stores/color-store";
import useRadiusStore from "@/stores/radius-store";
import UserMenu from "@/components/app/user/menu";
import useThemeStore from "@/stores/theme-store";
import {
  SidebarInset,
  SidebarProvider,
  SidebarTrigger,
} from "@/components/ui/sidebar";

type AuthLayoutProps = {
  children: React.ReactNode;
};

function AuthLayout({ children }: AuthLayoutProps) {
  const auth = useAuth();
  const isMobile = useMaxLg();
  const mainRef = useRef<HTMLDivElement>(null);

  const { setColor } = useColorStore();
  const { setRadius } = useRadiusStore();
  const { setTheme } = useThemeStore();

  const { color, radius, theme } = auth?.configuration ?? {};

  useEffect(() => {
    if (color) {
      setColor(color);
    }
    if (radius) {
      setRadius(radius);
    }
    if (theme) {
      setTheme(theme);
    }
  }, [color, radius, theme]);

  return (
    <SidebarProvider isMobile={isMobile}>
      <AppSidebar />
      <SidebarInset>
        <header className="bg-background sticky top-0 flex h-12 items-center gap-3 border-b px-3">
          {isMobile ? (
            <>
              <SidebarTrigger />
              <Separator orientation="vertical" />
            </>
          ) : null}

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
