import { Button } from "@narsil-cms/blocks";
import {
  CardContent,
  CardFooter,
  CardHeader,
  CardRoot,
  CardTitle,
} from "@narsil-cms/components/card";

type CardProps = React.ComponentProps<typeof CardRoot> & {
  contentProps?: Partial<React.ComponentProps<typeof CardContent>>;
  footerButtons?: React.ComponentProps<typeof Button>[];
  footerProps?: Partial<React.ComponentProps<typeof CardFooter>>;
  headerButtons?: React.ComponentProps<typeof Button>[];
  headerProps?: Partial<React.ComponentProps<typeof CardHeader>>;
  title?: string;
  titleProps?: Partial<React.ComponentProps<typeof CardTitle>>;
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
