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
    <Card className="absolute top-1/2 left-1/2 w-[20rem] -translate-x-1/2 -translate-y-1/2 transform">
      <CardContent>
        <Form method="post" url={route("login")}>
          <FormField
            name="email"
            render={({ onChange, ...field }) => (
              <FormItem>
                <FormLabel required={true} />
                <Input
                  autoComplete="email"
                  type="email"
                  onChange={(e) => onChange(e.target.value)}
                  {...field}
                />
                <FormMessage />
              </FormItem>
            )}
          />
          <FormField
            name="password"
            render={({ onChange, ...field }) => (
              <FormItem>
                <div className="flex items-center justify-between">
                  <FormLabel required={true} />
                  <Link className="text-xs" href={route("password.request")}>
                    Mot de passe oublié?
                  </Link>
                </div>
                <Input
                  autoComplete="new-password"
                  type="password"
                  onChange={(e) => onChange(e.target.value)}
                  {...field}
                />
                <FormMessage />
              </FormItem>
            )}
          />
          <FormField
            name="remember"
            render={({ value, onChange, ...field }) => (
              <FormItem className="flex-row">
                <Checkbox
                  checked={value}
                  onCheckedChange={(checked) => onChange(checked)}
                  {...field}
                />
                <FormDescription>Remember</FormDescription>
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
