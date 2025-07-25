import { ModalRenderer } from "@narsil-cms/components/ui/modal";
import { Separator } from "@narsil-cms/components/ui/separator";
import { Toaster } from "@narsil-cms/components/ui/toaster";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { useEffect, useRef } from "react";
import { useMaxLg } from "@narsil-cms/hooks/use-breakpoints";
import AppBreadcrumb from "@narsil-cms/components/app/app-breadcrumb";
import AppSidebar from "@narsil-cms/components/app/app-sidebar";
import useColorStore from "@narsil-cms/stores/color-store";
import useRadiusStore from "@narsil-cms/stores/radius-store";
import UserMenu from "@narsil-cms/components/app/user/menu";
import useThemeStore from "@narsil-cms/stores/theme-store";
import {
  SidebarInset,
  SidebarProvider,
  SidebarTrigger,
} from "@narsil-cms/components/ui/sidebar";

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
        <header className="bg-background sticky top-0 z-10 flex h-12 items-center gap-3 border-b px-3">
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
