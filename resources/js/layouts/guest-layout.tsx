import { Link } from "@inertiajs/react";
import { Container } from "@narsil-cms/blocks/container";
import { Icon } from "@narsil-cms/blocks/icon";
import { Logo } from "@narsil-cms/blocks/logo";
import { Toaster } from "@narsil-cms/blocks/toaster";
import { ThemeToggleGroup } from "@narsil-cms/blocks/toggle-group";
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
import { Tooltip } from "@narsil-cms/components/tooltip";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { groupBy } from "lodash-es";
import { Fragment, type ReactNode, useRef } from "react";

type GuestLayoutProps = {
  children: ReactNode & {
    props: GlobalProps;
  };
};

function GuestLayout({ children }: GuestLayoutProps) {
  const { trans } = useLocalization();

  const mainRef = useRef<HTMLDivElement>(null);

  const { navigation } = children?.props;

  const groupedMenu = groupBy(navigation?.userMenu, (item) => item.group ?? "default");

  return (
    <>
      <header className="sticky top-0 z-10 h-13 border-b bg-sidebar shadow">
        <Container className="flex items-center justify-between gap-4">
          <Logo />
          <DropdownMenuRoot>
            <Tooltip tooltip={trans("accessibility.toggle_user_menu")}>
              <DropdownMenuTrigger
                render={
                  <Button size="icon" variant="ghost">
                    <Icon name="menu" />
                  </Button>
                }
              />
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
        </Container>
      </header>
      <main ref={mainRef} className="relative min-h-[calc(100vh-3.25rem)] overflow-hidden">
        <BackgroundRoot className="filter-[url(#paper)]">
          <BackgroundPaper />
        </BackgroundRoot>
        <ModalRenderer container={mainRef.current} />
        {children}
        <Toaster />
      </main>
    </>
  );
}

export default GuestLayout;
