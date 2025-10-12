import {
  Bookmarks,
  Breadcrumb,
  Button,
  Separator,
  Sidebar,
  ThemeToggleGroup,
  Toaster,
  Tooltip,
} from "@narsil-cms/blocks";
import { AvatarFallback, AvatarImage, AvatarRoot } from "@narsil-cms/components/avatar";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { ModalRenderer } from "@narsil-cms/components/modal";
import { SidebarInset, SidebarProvider, SidebarTrigger } from "@narsil-cms/components/sidebar";
import { useMaxLg } from "@narsil-cms/hooks/use-breakpoints";
import { GlobalProps } from "@narsil-cms/hooks/use-props";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { useThemeStore } from "@narsil-cms/stores/theme-store";
import { groupBy } from "lodash";
import { useEffect, useRef } from "react";
import { Fragment } from "react/jsx-runtime";

type AuthLayoutProps = {
  children: React.ReactNode & {
    props: GlobalProps;
  };
};

function AuthLayout({ children }: AuthLayoutProps) {
  const { trans } = useLocalization();

  const isMobile = useMaxLg();
  const mainRef = useRef<HTMLDivElement>(null);

  const { setColor } = useColorStore();
  const { setRadius } = useRadiusStore();
  const { setTheme } = useThemeStore();

  const { auth, navigation, session } = children?.props;
  const { color, radius, theme } = session;

  const groupedMenu = groupBy(navigation?.userMenu, (item) => item.group ?? "default");

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
  }, []);

  return (
    <SidebarProvider isMobile={isMobile}>
      <Sidebar />
      <SidebarInset>
        <header className="h-13 bg-background sticky top-0 z-10 flex items-center gap-2 border-b pl-2 pr-4 xl:pl-4">
          {isMobile ? (
            <>
              <SidebarTrigger />
              <Separator orientation="vertical" />
            </>
          ) : null}
          <Breadcrumb className="grow" />
          <Bookmarks breadcrumb={navigation.breadcrumb} />
          <DropdownMenuRoot>
            <Tooltip tooltip={trans("accessibility.toggle_user_menu")}>
              <DropdownMenuTrigger>
                <AvatarRoot>
                  {auth.avatar ? (
                    <AvatarImage src={auth.avatar} alt={auth.full_name ?? "User"} />
                  ) : null}
                  <AvatarFallback>
                    <Icon name="user" />
                  </AvatarFallback>
                </AvatarRoot>
              </DropdownMenuTrigger>
            </Tooltip>
            <DropdownMenuContent align="end">
              {Object.entries(groupedMenu).map(([group, items], groupIndex) => {
                return (
                  <Fragment key={group}>
                    {groupIndex > 0 && <DropdownMenuSeparator />}
                    {items.map((item, index) => {
                      return (
                        <DropdownMenuItem asChild={true} key={index}>
                          <Button
                            icon={item.icon}
                            linkProps={{
                              href: item.href,
                              method: item.method,
                              modal: item.modal,
                            }}
                            size="sm"
                            variant="ghost"
                          >
                            {item.label}
                          </Button>
                        </DropdownMenuItem>
                      );
                    })}
                  </Fragment>
                );
              })}
              <DropdownMenuSeparator />
              <ThemeToggleGroup className="w-full" />
            </DropdownMenuContent>
          </DropdownMenuRoot>
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
