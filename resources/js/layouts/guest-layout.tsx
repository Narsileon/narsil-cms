import { Link } from "@inertiajs/react";
import { ThemeToggleGroup } from "@narsil-cms/blocks/toggle-group";
import { ModalLink, ModalRenderer } from "@narsil-cms/components/modal";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { Button } from "@narsil-ui/components/button";
import { Container } from "@narsil-ui/components/container";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-ui/components/dropdown-menu";
import { Icon } from "@narsil-ui/components/icon";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { groupBy } from "lodash-es";
import { Fragment, type ReactNode, useRef } from "react";
import { route } from "ziggy-js";

type GuestLayoutProps = {
  children: ReactNode & {
    props: GlobalProps;
  };
};

function GuestLayout({ children }: GuestLayoutProps) {
  const { trans } = useTranslator();

  const mainRef = useRef<HTMLDivElement>(null);

  const { navigation } = children?.props;

  const groupedMenu = groupBy(navigation?.userMenu, (item) => item.group ?? "default");

  return (
    <>
      <header className="sticky top-0 z-10 h-13 border-b bg-sidebar shadow">
        <Container className="h-full flex-row justify-between">
          <Icon name="narsil" />
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
                          const itemContent = (
                            <>
                              {item.icon ? <Icon name={item.icon} /> : null}
                              {item.label}
                            </>
                          );

                          return (
                            <DropdownMenuItem
                              key={index}
                              render={
                                <Button
                                  size="sm"
                                  variant="ghost"
                                  render={
                                    item.modal ? (
                                      <ModalLink
                                        href={route(item.route, item.parameters)}
                                        method={item.method}
                                      >
                                        {itemContent}
                                      </ModalLink>
                                    ) : (
                                      <Link
                                        href={route(item.route, item.parameters)}
                                        method={item.method}
                                      >
                                        {itemContent}
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
        <ModalRenderer container={mainRef.current} />
        {children}
      </main>
    </>
  );
}

export default GuestLayout;
