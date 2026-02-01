import { Link } from "@inertiajs/react";
import { Bookmarks } from "@narsil-cms/blocks/bookmarks";
import { Breadcrumb } from "@narsil-cms/blocks/breadcrumb";
import { Icon } from "@narsil-cms/blocks/icon";
import { Sidebar } from "@narsil-cms/blocks/sidebar";
import { Toaster } from "@narsil-cms/blocks/toaster";
import { ThemeToggleGroup } from "@narsil-cms/blocks/toggle-group";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { AlertDialogProvider } from "@narsil-cms/components/alert-dialog";
import { AvatarFallback, AvatarImage, AvatarRoot } from "@narsil-cms/components/avatar";
import { BackgroundRoot } from "@narsil-cms/components/background";
import BackgroundPaper from "@narsil-cms/components/background/background-paper";
import { Button } from "@narsil-cms/components/button";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useLocalization } from "@narsil-cms/components/localization";
import { ModalLink, ModalRenderer } from "@narsil-cms/components/modal";
import { Separator } from "@narsil-cms/components/separator";
import { SidebarInset, SidebarProvider, SidebarTrigger } from "@narsil-cms/components/sidebar";
import { useMaxLg } from "@narsil-cms/hooks/use-breakpoints";
import { GlobalProps } from "@narsil-cms/hooks/use-props";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { useThemeStore } from "@narsil-cms/stores/theme-store";
import { groupBy } from "lodash-es";
import { Fragment, type ReactNode, useEffect, useRef } from "react";

type AuthLayoutProps = {
  children: ReactNode & {
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
    requestAnimationFrame(() => {
      if (color) {
        setColor(color);
      }
      if (radius) {
        setRadius(radius);
      }
      if (theme) {
        setTheme(theme);
      }
    });
  }, []);

  return (
    <AlertDialogProvider>
      <SidebarProvider isMobile={isMobile}>
        <Sidebar />
        <SidebarInset>
          <header className="sticky top-0 z-10 flex h-13 items-center gap-2 border-b bg-background pr-4 pl-2 text-foreground xl:pl-4">
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
              <DropdownMenuPortal>
                <DropdownMenuPositioner align="end">
                  <DropdownMenuPopup>
                    {Object.entries(groupedMenu).map(([group, items], groupIndex) => {
                      return (
                        <Fragment key={group}>
                          {groupIndex > 0 && <DropdownMenuSeparator />}
                          {items.map((item, index) => {
                            return (
                              <DropdownMenuItem
                                key={index}
                                render={
                                  <Button
                                    size="sm"
                                    variant="ghost"
                                    render={
                                      item.modal ? (
                                        <ModalLink href={item.href} method={item.method}>
                                          <Icon name={item.icon} />
                                          {item.label}
                                        </ModalLink>
                                      ) : (
                                        <Link href={item.href} method={item.method}>
                                          <Icon name={item.icon} />
                                          {item.label}
                                        </Link>
                                      )
                                    }
                                  />
                                }
                              />
                            );
                          })}
                        </Fragment>
                      );
                    })}
                    <DropdownMenuSeparator />
                    <ThemeToggleGroup className="w-full" />
                  </DropdownMenuPopup>
                </DropdownMenuPositioner>
              </DropdownMenuPortal>
            </DropdownMenuRoot>
          </header>
          <div ref={mainRef} className="relative h-[calc(100vh-3.25rem)] overflow-y-auto">
            <BackgroundRoot className="filter-[url(#paper)]">
              <BackgroundPaper />
            </BackgroundRoot>
            <ModalRenderer container={mainRef.current} />
            {children}
            <Toaster />
          </div>
        </SidebarInset>
      </SidebarProvider>
    </AlertDialogProvider>
  );
}

export default AuthLayout;
