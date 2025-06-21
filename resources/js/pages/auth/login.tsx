import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Link } from "@inertiajs/react";
import { useRoute } from "ziggy-js";
import {
  Form,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";

type LoginProps = {
  status?: string;
};

const Index = ({ status }: LoginProps) => {
  const route = useRoute();

  return (
    <Card className="max-w-[20rem]">
      <CardContent>
        <Form className="grid gap-4" method="post" url={route("login")}>
          <FormField
            name="email"
            render={(field) => (
              <FormItem>
                <FormLabel required={true}>Email</FormLabel>
                <Input
                  autoComplete="email"
                  type="email"
                  value={field.value}
                  onChange={(e) => field.onChange(e.target.value)}
                />
                <FormMessage />
              </FormItem>
            )}
          />
          <FormField
            name="password"
            render={(field) => (
              <FormItem>
                <FormLabel required={true}>Password</FormLabel>
                <Input
                  autoComplete="new-password"
                  type="password"
                  value={field.value}
                  onChange={(e) => field.onChange(e.target.value)}
                />

                <FormDescription>
                  <Link className="text-xs" href={route("password.request")}>
                    Mot de passe oublié?
                  </Link>
                </FormDescription>
                <FormMessage />
              </FormItem>
            )}
          />
          <FormField
            name="remember"
            render={(field) => (
              <FormItem orientation="horizontal">
                <Checkbox
                  checked={field.value}
                  onCheckedChange={(checked) => field.onChange(checked)}
                />
                <FormDescription>Remember</FormDescription>
                <FormMessage />
              </FormItem>
            )}
          />
          <Button type="submit">Login</Button>
        </Form>
        {status}
      </CardContent>
    </Card>
  );
};

export default Index;
