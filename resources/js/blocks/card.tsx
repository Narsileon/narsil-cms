import { Button } from "@narsil-cms/blocks";
import {
  CardContent,
  CardFooter,
  CardHeader,
  CardRoot,
  CardTitle,
} from "@narsil-cms/components/card";
import { type ComponentProps } from "react";

type CardProps = ComponentProps<typeof CardRoot> & {
  contentProps?: Partial<ComponentProps<typeof CardContent>>;
  footerButtons?: ComponentProps<typeof Button>[];
  footerProps?: Partial<ComponentProps<typeof CardFooter>>;
  headerButtons?: ComponentProps<typeof Button>[];
  headerProps?: Partial<ComponentProps<typeof CardHeader>>;
  title?: string;
  titleProps?: Partial<ComponentProps<typeof CardTitle>>;
};

function Card({
  children,
  contentProps,
  footerButtons,
  footerProps,
  headerButtons,
  headerProps,
  title,
  titleProps,
  ...props
}: CardProps) {
  return (
    <CardRoot {...props}>
      {title && (
        <CardHeader {...headerProps}>
          <CardTitle {...titleProps}>{title}</CardTitle>
          {headerButtons?.map((button, index) => (
            <Button {...button} key={index} />
          ))}
        </CardHeader>
      )}
      <CardContent {...contentProps}>{children}</CardContent>
      {footerButtons && (
        <CardFooter {...footerProps}>
          {footerButtons.map((button, index) => (
            <Button {...button} key={index} />
          ))}
        </CardFooter>
      )}
    </CardRoot>
  );
}

export default Card;
