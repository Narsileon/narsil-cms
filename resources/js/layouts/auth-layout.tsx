import { useEffect, useRef } from "react";

import {
  Bookmarks,
  Breadcrumb,
  Separator,
  Sidebar,
  Toaster,
  UserMenu,
} from "@narsil-cms/blocks";
import { ModalRenderer } from "@narsil-cms/components/modal";
import {
  SidebarInset,
  SidebarProvider,
  SidebarTrigger,
} from "@narsil-cms/components/sidebar";
import { useMaxLg } from "@narsil-cms/hooks/use-breakpoints";
import { GlobalProps } from "@narsil-cms/hooks/use-props";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { useThemeStore } from "@narsil-cms/stores/theme-store";

type AuthLayoutProps = {
  children: React.ReactNode & {
    props: GlobalProps;
  };
};

function AuthLayout({ children }: AuthLayoutProps) {
  const { auth, navigation } = children?.props;

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
      <Sidebar />
      <SidebarInset>
        <header className="sticky top-0 z-10 flex h-13 items-center gap-2 border-b bg-background pr-4 pl-2 xl:pl-4">
          {isMobile ? (
            <>
              <SidebarTrigger />
              <Separator orientation="vertical" />
            </>
          ) : null}
          <Breadcrumb className="grow" />
          <Bookmarks breadcrumb={navigation.breadcrumb} />
          <UserMenu />
        </header>
        <main ref={mainRef} className="relative min-h-[calc(100vh-3.25rem)]">
          <ModalRenderer container={mainRef.current} />
          {children}
          <Toaster />
        </main>
      </SidebarInset>
    </SidebarProvider>
  );
}

export default AuthLayout;
